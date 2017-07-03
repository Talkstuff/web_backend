<?php

namespace Modules\Media\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Core\Repositories\FilesRepository;
use Modules\Media\Repositories\MediaRepository;
use Modules\Media\Transformers\MediaTransformer;
use Modules\Users\Models\User;
use Modules\Users\Repositories\UsersRepository;

class MediaController extends Controller
{
    /**
     * @var MediaRepository
     */
    private $mediaRepository;

    /**
     * MediaController constructor.
     * @param MediaRepository $mediaRepository
     */
    public function __construct(MediaRepository $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    public function uploadImage($userId)
    {

        $media = $this->mediaRepository->uploadImageMedia($userId, request()->file('image'));

        return transform($media, new MediaTransformer());
    }

    public function changeProfileImage($userId)
    {

        $media = $this->mediaRepository->uploadImageMedia($userId, request()->file('image'));

        /**
         * @var User $user
         */
        $user = app(UsersRepository::class)->findById($userId);

        $meta = setMetaData($user->metadata, [
            'profileMediaSource' => $media->source
        ]);

        $user->fill(['metadata' => $meta]);

        $user->save();

        return transform($media, new MediaTransformer());
    }

    public function changeCoverImage($userId)
    {

        $media = $this->mediaRepository->uploadImageMedia($userId, request()->file('image'));

        /**
         * @var User $user
         */
        $user = app(UsersRepository::class)->findById($userId);

        $meta = setMetaData($user->metadata, [
            'coverMediaSource' => $media->source
        ]);

        $user->fill(['metadata' => $meta]);

        $user->save();

        return transform($media, new MediaTransformer());
    }
}
