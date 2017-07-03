<?php
/**
 * Created by PhpStorm.
 * User: Dennis
 * Date: 19/05/2017
 * Time: 03:42 PM
 */

namespace Modules\Media\Repositories;


use Modules\Core\Repositories\FilesRepository;
use Modules\Media\Models\Media;
use Modules\Media\Models\MediaCategory;

class MediaRepository
{
    /**
     * @var Media
     */
    private $media;
    /**
     * @var MediaCategory
     */
    private $mediaCategory;
    /**
     * @var FilesRepository
     */
    private $filesRepository;


    /**
     * MediaRepository constructor.
     * @param Media $media
     * @param MediaCategory $mediaCategory
     * @param FilesRepository $filesRepository
     */
    public function __construct(Media $media, MediaCategory $mediaCategory, FilesRepository $filesRepository)
    {
        $this->media = $media;
        $this->mediaCategory = $mediaCategory;
        $this->filesRepository = $filesRepository;
    }

    /**
     * @param $userId
     * @param $file
     * @return Media
     */
    public function uploadImageMedia($userId, $file)
    {
        $catId = $this->getUserDefaultImageAlbum($userId);

        $source = $this->filesRepository->uploadFile(null,'media/images/' . $userId, $file);

        $image = $this->media->create([
            'source' => asset($source),
            'type' => Media::IMAGE_TYPE,
            'user_id' => $userId,
            'privacy' => Media::PRIVACY_FRIENDS
        ]);

        $this->placeMediaInCategory($image, $catId->id);

        return $image;
    }

    /**
     * @param $userId
     * @return MediaCategory
     */
    private function getUserDefaultImageAlbum($userId)
    {
        return $this->mediaCategory->firstOrCreate([
            'user_id' => $userId,
            'name' => 'Uncategorized',
            'type' => MediaCategory::IMAGE_TYPE
        ]);

    }

    private function placeMediaInCategory(Media $media, $category_id)
    {
        $media->categories()->attach($category_id);
    }


    private function getUserDefaultVideoAlbum($userId)
    {
        return $this->mediaCategory->firstOrCreate([
            'user_id' => $userId,
            'name' => 'Uncategorized',
            'type' => MediaCategory::VIDEO_TYPE
        ]);

    }

    public function saveVideo($userId, $url)
    {
        $video = $this->media->create([
            'source' => $url,
            'type' => Media::VIDEO_TYPE,
            'user_id' => $userId,
            'privacy' => Media::PRIVACY_FRIENDS
        ]);

        $category = $this->getUserDefaultVideoAlbum($userId);

        $this->placeMediaInCategory($video, $category->id);

        return $video;
    }
}