<?php

namespace Modules\Casting\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Casting\Mail\CandidateRegistered;
use Modules\Casting\Repositories\CastingRepository;
use Modules\Core\Repositories\FilesRepository;
use Modules\Users\Models\User;
use Modules\Users\Repositories\UsersRepository;

class CastingController extends Controller
{
    /**
     * @var CastingRepository
     */
    private $castingRepository;
    /**
     * @var FilesRepository
     */
    private $filesRepository;

    /**
     * CastingController constructor.
     * @param CastingRepository $castingRepository
     * @param FilesRepository $filesRepository
     */
    public function __construct(CastingRepository $castingRepository, FilesRepository $filesRepository)
    {
        $this->castingRepository = $castingRepository;
        $this->filesRepository = $filesRepository;
    }

    public function uploadImage()
    {
        $uploadPath = $this->filesRepository->uploadFile(null, 'casting/images', request()->file('image'));
        return response()->json(['path' => url($uploadPath)]);
    }

    public function uploadHeadShotImage()
    {
        $uploadPath = $this->filesRepository->uploadFile(null, 'casting/headshots', request()->file('image'));
        return response()->json(['path' => url($uploadPath)]);
    }

    public function submitCast()
    {
        /**
         * @var User $user
         */
        $user = getJwtUser();

        $this->validate(request(), [
            'fullName' => 'required',
            'gender' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'dateOfBirth' => 'required',
            'eyeColour' => 'required',
            'country' => 'required',
            'hairColour' => 'required',
            'height' => 'required',
            'shoeSize' => 'required',
            'waistSize' => 'required',
            'chestSize' => 'required',
            'imageAttachments' => 'required',
            'headShotImage' => 'required',
        ]);

        $cast = $this->castingRepository->saveCast($user->id, request()->all());

        \Mail::send(new CandidateRegistered($cast));

        return $cast;
    }
}
