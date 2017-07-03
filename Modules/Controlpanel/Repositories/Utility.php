<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 04/02/2016
 * Time: 09:12 PM
 */

namespace Modules\Controlpanel\Repositories;


use Chumper\Zipper\Zipper;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Repositories\FilesRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;


class Utility
{
    /**
     * @var Zipper
     */
    private $zipper;
    /**
     * @var FilesRepository
     */
    private $filesRepository;

    /**
     * Utility constructor.
     * @param Zipper $zipper
     * @param FilesRepository $filesRepository
     */
    public function __construct(Zipper $zipper, FilesRepository $filesRepository)
    {

        $this->zipper = $zipper;
        $this->filesRepository = $filesRepository;
    }

    public function response_notification($title, $info ='', $class = 'info'){
        $message['title'] = $title;
        $message['message'] = $info;
        $message['class'] = $class;

        \Session::flash('message',$message);
    }

    public function uploadFile(UploadedFile $uploadedFile, $upload_path = '', $upload_filename =''){

        return $uploadedFile->move($upload_path, $upload_filename);
    }

    public function uploadImage(UploadedFile $uploadedFile, $upload_dir = '',$upload_filename = '', array $resize_option){
        $uploaded_image = \Image::make($uploadedFile);

        if(!starts_with($upload_dir,'/')) $upload_dir = '/' . $upload_dir;

        $save_path = 'uploads' . $upload_dir . '/images/';

        // resize image
        $uploaded_image->resize($resize_option[0], $resize_option[1], function($constraint){
            return $constraint->aspectRatio();
        });

        $upload_filename = $upload_filename . '.' . $uploadedFile->getClientOriginalExtension();

        // save to upload directory
        $uploaded_image->save($this->public_save_path($save_path) . $upload_filename);

        return $save_path . $upload_filename;
    }

    protected function public_save_path($path){

        if(!\Storage::disk('public')->exists($path)){

            \Storage::disk('public')->makeDirectory($path);
        }

        return $path;
    }

    public static function httpCommunicator($url, $method = 'get', $data = null, $decode = false, $async = true){
        $guzzle = new Client();

        // send request
        $req = new Request($method, $url);

        if($data) $req->setQuery($data);

        $res = $guzzle->send($req);

        $result = $res->getBody()->getContents();

        if($decode) $result = json_decode($result);

        return $result;
    }

    protected static function prepareQueryString(array $params = []){
        $count = count($params);

        if(count($params) > 0){
            $query_string = '?';

            $i = 0;

            //dd($this->config);
            foreach($params as $index => $parameter){
                $query_string .= $index . '=' . $parameter ;

                if(($i + 1) != $count) {
                    // last item in the array
                    $query_string .= '&';
                }

                $i++;
            }
            //dd($query_string);
            return $query_string;
        }
        return '';
    }

    public static function buildUrl($url, array $params = []){

        $query_string = static::prepareQueryString($params);

        //dd($url . $query_string);

        return $url . $query_string;
    }

    public function uploadModule(UploadedFile $uploadedFile)
    {
        if(!$uploadedFile) return false;

        $uploaded_file_path =
            $this->filesRepository->uploadFile($uploadedFile->getClientOriginalName(), null, $uploadedFile);

        // extract module to designated folder
        $this->zipper->make(public_path($uploaded_file_path))->extractTo(base_path('Modules'));

        $this->zipper->close();

        // after upload and extract
        // return the module name
        $filename = $uploadedFile->getClientOriginalName();
        return str_slug(explode('.', $filename)[0]);
    }
}