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
use Modules\Media\Models\MediaComment;
use Modules\Users\Models\User;

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
     * @var  MediaComment
     */
    private $mediaComment;

    /**
     * @var  User
     */
    private $user;


    /**
     * MediaRepository constructor.
     * @param Media $media
     * @param MediaCategory $mediaCategory
     * @param FilesRepository $filesRepository
     * @param  User $user
     */
    public function __construct(Media $media,User $user, MediaCategory $mediaCategory, FilesRepository $filesRepository)
    {
        $this->media = $media;
        $this->mediaCategory = $mediaCategory;
        $this->filesRepository = $filesRepository;
        $this->user=$user;
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
     * @param $payLoad
     * @param $file
     * @return Media
     */
    public function uploadPhotoViaMedia(array $payLoad)
    {
        $catId = $this->getUserMediaCategory($payLoad);
        $source = $this->filesRepository->uploadFile(null,'media/images/' . $payLoad['userId'], $payLoad['file']);

        $image = $this->media->create([
            'source' => asset($source),
            'type' => Media::MUSIC_TYPE,
            'user_id' => $payLoad['userId'],
            'privacy' => $payLoad['privacy']
        ]);

        $this->placeMediaInCategory($image, $catId->id);

        return $image;
    }


    /**
     * @param $payLoad
     * @param $file
     * @return Media
     */
    public function uploadMusicMedia(array $payLoad)
    {
        $catId = $this->getUserMediaCategory($payLoad);
        $source = $this->filesRepository->uploadFile(null,'media/music/' . $payLoad['userId'], $payLoad['file']);

        $music = $this->media->create([
            'source' => asset($source),
            'type' => Media::MUSIC_TYPE,
            'user_id' => $payLoad['userId'],
            'privacy' => $payLoad['privacy'],
            'metadata'=> $payLoad['$payLoad']
        ]);

        $this->placeMediaInCategory($music, $catId->id);

        return $music;
    }


    /**
     * @param $payLoad
     * @param $file
     * @return Media
     */
    public function uploadVideoMedia(array $payLoad)
    {
        $catId = $this->getUserMediaCategory($payLoad);
        $source = $this->filesRepository->uploadFile(null,'media/video/' . $payLoad['userId'], $payLoad['file']);

        $video = $this->media->create([
            'source' => asset($source),
            'type' => Media::VIDEO_TYPE,
            'user_id' => $payLoad['userId'],
            'privacy' => $payLoad['privacy']
        ]);

        $this->placeMediaInCategory($video, $catId->id);

        return $video;
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


    /**
     * @param $payload
     * @return MediaCategory
     */
    private function getUserMediaCategory(array $payload){
        return $this->mediaCategory->firstOrCreate([
            'user_id' => $payload['userId'],
            'name' => $payload['category'],
            'type' => $payload['type']
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

    public function saveVideoViaMedia(array $payLoad){
        $catId = $this->getUserMediaCategory($payLoad);

        $video = $this->media->create([
            'source' => $payLoad['url'],
            'type' => Media::VIDEO_TYPE,
            'user_id' => $payLoad['userId'],
            'privacy' => $payLoad['privacy']
        ]);

        $this->placeMediaInCategory($video, $catId->id);

        return $video;
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

    public function placeMedia(Media $media,$cat_id){
        $this->placeMediaInCategory($media, $cat_id);
    }

    public function createUserMediaCategory(array $payLoad)
    {
        $editMode = isset($payLoad['id']) ? true : false;

        /**
         * @var MediaCategory $MediaCategory
         */
        $MediaCategory = $this->mediaCategory->firstOrNew([
            'id' => $editMode ? $payLoad['id'] : null
        ]);

        $MediaCategory->fill([
            'user_id' => $payLoad['userId'],
            'name' => $payLoad['category'],
            'type' => $payLoad['type']
        ]);
        $MediaCategory->save();
        return $MediaCategory;
    }

    public function getFeaturedPhotos(){
        return $this->media
            ->where('blocked', false)
            ->where('featured', true)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type',Media::IMAGE_TYPE)->latest()
            ->simplePaginate(20);
    }

    public function getFeaturedVideos(){
        return $this->media
            ->where('blocked',false)
            ->where('featured', true)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type','=',Media::VIDEO_TYPE)->latest()
            ->simplePaginate(20);
    }

    public function getFeaturedMusic(){
        return $this->media
            ->where('blocked',false)
            ->where('featured',true)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type',Media::MUSIC_TYPE)->latest()
            ->simplePaginate(20);
    }

    public function getMostLikedMusics(){
        return $this->media
            ->where('blocked', false)
            ->where('likes', '>=', 10)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type',Media::MUSIC_TYPE)->latest()
            ->simplePaginate(20);
    }

    public function getMostLikedVideos(){
        return $this->media
            ->where('blocked', false)
            ->where('likes', '>=', 10)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type',Media::VIDEO_TYPE)->latest()
            ->simplePaginate(20);
    }

    public function getMostLikedPhotos(){
        return $this->media
            ->where('blocked', false)
            ->where('likes', '>=', 10)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type',Media::IMAGE_TYPE)->latest()
            ->simplePaginate(20);
    }

    public function getMostDownloadedMusics(){
        return $this->media
            ->where('blocked', false)
            ->where('downloads', '>=', 10)
            ->where('privacy',3)
            ->where('type',3)->latest()
            ->simplePaginate(20);
    }

    public function getMostDownloadedPhotos(){
        return $this->media
            ->where('blocked', false)
            ->where('downloads', '>=', 10)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type',Media::IMAGE_TYPE)->latest()
            ->simplePaginate(20);
    }

    public function getMostDownloadedVideos(){
        return $this->media
            ->where('blocked', false)
            ->where('downloads', '>=', 10)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type','=',Media::VIDEO_TYPE)->latest()
            ->simplePaginate(20);
    }

    public function getMostSharedMusics(){
        return $this->media
            ->where('blocked', false)
            ->where('shares', '>=', 10)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type',Media::MUSIC_TYPE)->latest()
            ->simplePaginate(20);
    }

    public function getMostSharedPhotos(){
        return $this->media
            ->where('blocked',false)
            ->where('shares', '>=', 10)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type',Media::IMAGE_TYPE)->latest()
            ->simplePaginate(20);
    }

    public function getMostSharedVideos(){
        return $this->media
            ->where('blocked',false)
            ->where('shares', '>=', 10)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type',Media::VIDEO_TYPE)->latest()
            ->simplePaginate(20);
    }

    public function getOtherMusics(){
        return $this->media
            ->where('blocked', false)
            ->where('featured',false)
            ->where('downloads', '<', 10)
            ->where('likes', '<', 10)
            ->where('views', '<', 10)
            ->where('shares', '<', 10)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type',Media::MUSIC_TYPE)->latest()
            ->simplePaginate(20);
    }
    public function getOtherPhotos(){
        return $this->media
            ->where('blocked', false)
            ->where('featured',false)
            ->where('downloads', '<', 10)
            ->where('likes', '<', 10)
            ->where('views', '<', 10)
            ->where('shares', '<', 10)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type',Media::IMAGE_TYPE)->latest()
            ->simplePaginate(20);
    }

    public function getOtherVideos(){
        return $this->media
            ->where('blocked', false)
            ->where('featured',false)
            ->where('downloads', '<', 10)
            ->where('likes', '<', 10)
            ->where('views', '<', 10)
            ->where('shares', '<', 10)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type',Media::VIDEO_TYPE)->latest()
            ->simplePaginate(20);
    }

    public function getAllUnblockedPublicVideos(){
        return $this->media
            ->where('blocked', false)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type',Media::VIDEO_TYPE)->latest()
            ->simplePaginate(20);
    }

    public function getAllUnblockedPublicMusics(){
        return $this->media
            ->where('blocked', false)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type',Media::MUSIC_TYPE)->latest()
            ->simplePaginate(20);
    }

    public function getAllUnblockedPublicPhotos(){
        return $this->media
            ->where('blocked', false)
            ->where('privacy',Media::PRIVACY_PUBLIC)
            ->where('type',Media::IMAGE_TYPE)->latest()
            ->simplePaginate(20);
    }

    public function getCategoryMedias($user_id,$catName,$type){
        $cat_id=$this->mediaCategory
            ->where('name',$catName)
            ->where('type',$type)
            ->where('user_id',$user_id)
            ->first();
        return $this->mediaCategory
            ->find($cat_id->id)
            ->media()->latest()->simplePaginate(20);
    }

    public function getUserMediaCategories($user_id,$type){
        return $this->mediaCategory
            ->where('type',$type)
            ->where('user_id',$user_id)
            ->get();
    }

    public function incrementMediaLikes($media_id){
        return $this->media->find($media_id)->increment('likes',1);
    }

    public function incrementMediaDislikes($media_id){
        return $this->media
            ->find($media_id)
            ->increment('dislikes',1);
    }

    public function incrementMediaDownloads($media_id){
        return $this->media
            ->find($media_id)
            ->increment('downloads',1);
    }

    public function incrementMediaShares($media_id){
        return $this->media
            ->find($media_id)
            ->increment('shares',1);
    }

    public function incrementMediaViews($media_id){
        return $this->media
            ->find($media_id)
            ->increment('views',1);
    }

    public function FeatureMedia($media_id){
        return $this->media
            ->find($media_id)
            ->update(['featured' => true]);
    }

    public function DeleteMedia($media_id){
        return $this->media
            ->find($media_id)
            ->delete();
    }

    public function getMediaById($media_id){
        return $this->media
            ->find($media_id);
    }

    public function makeComment(array $payLoad)
    {
        $editMode = isset($payLoad['id']) ? true : false;

        /**
         * @var MediaComment $MediaComment
         */
        $MediaComment = $this->mediaComment->firstOrNew([
            'id' => $editMode ? $payLoad['id'] : null
        ]);

        $MediaComment->fill([
            'media_id' => $payLoad['media_id'],
            'sender_id' => $payLoad['sender_id'],
            'comment' => $payLoad['comment']
        ]);
        $MediaComment->save();
        return $MediaComment;
    }

    public function getUserWhoCommented($userId){
        return $this->user->find($userId);
    }

}