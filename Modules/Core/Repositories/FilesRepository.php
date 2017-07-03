<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 28/07/2016
 * Time: 05:32 PM
 */

namespace Modules\Core\Repositories;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class FilesRepository
{
    private $explorer;

    /**
     * FilesRepository constructor.
     */
    public function __construct()
    {
        $this->explorer = \Storage::disk($this->getDiskName());
    }


    public function getFiles($path = null){
        $this->explorer->allFiles();
        if(!$path) $path = '/';

        $items = $this->getItemsInPath($path);

        return $items;
    }

    public function getItemsInPath($path){
        // get directories
        $items = [];
        $directories = $this->explorer->directories($path);

        $this->listFilesInDir($path, $directories, $items, true);

        // get files
        $files = $this->explorer->files($path);
        $this->listFilesInDir($path, $files, $items);

        return $items;
    }

    private function listFilesInDir($path, $files, &$items, $isDir = false){
        if(count($files) >0){
            foreach($files as $file){
                $file_explorerPath = $isDir ? $path . $file .  '/' : $path . $file . '';
                $items[] = [
                    'name' => $file,
                    'path' => $file_explorerPath,
                    'fullPath' => '/explorer' . $path . $file,
                    'isDir' => $isDir,
                    'size' => $isDir ? : $this->getFileSize($file_explorerPath),
                    'modified' => $this->getLastModified($file_explorerPath)
                ];
            }
        }
    }

    public function uploadFile($fileName = null, $uploadPath = null, $file = null){
        $uploadPath = $uploadPath ? $uploadPath : request()->get('path');

        if(!$file) $file = request()->file('file');

        if($fileName) {
            $path = $file->storeAs($uploadPath, $fileName . '.' . $file->clientExtension(),$this->getDiskName());
        } else {
            $path = $file->store($uploadPath, $this->getDiskName());
        }

        return $this->explorer->url('uploads/' . $path);
    }

    public function deleteFile($file_path)
    {
        if($file_path) $this->explorer->delete($file_path);
    }


    private function uploadToPath(UploadedFile $file, $uploadPath)
    {
        $fileName = $this->getFileName($file, $uploadPath);

        $file->move($this->getUploadPath($uploadPath),$fileName);

        return $uploadPath . $fileName;


    }

    private function getFileName(UploadedFile $file, $uploadPath){
        $fileName = $file->getClientOriginalName();

        while($this->explorer->exists($uploadPath . $fileName)){
            $fileName = '1_' . $fileName;
        }

        return $fileName;
    }

    private function getUploadPath($path)
    {
        if($path == ''){
            // upload to root upload directory.
        } else {
            if(!ends_with($path,'/')){
                $path .= '/';
            }
            if(!$this->explorer->exists($path)){

               $this->explorer->makeDirectory($path);
            }
        }

        return 'explorer/' . $path;
    }

    private function getFileSize($file_explorerPath)
    {
        $byte = $this->explorer->size($file_explorerPath);
        $unit = 'MB';

        $size = fromBytesToMB($byte);

        if($size < 1) {
            $size = fromBytesToKB($byte);
            $unit = 'KB';
        }


        return $size . ' ' . $unit;
    }

    private function getLastModified($file)
    {
        $ts = $this->explorer->lastModified($file);

        return \Carbon\Carbon::createFromTimestamp($ts)->diffForHumans();
    }

    private function getDiskName()
    {
        return 'explorer';
    }

}