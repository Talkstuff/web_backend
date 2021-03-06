<?php

namespace Modules\Media\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Modules\Core\Repositories\FilesRepository;
use Modules\Media\Repositories\MediaRepository;
use Modules\Media\Transformers\MediaTransformer;
use Modules\Users\Repositories\UsersRepository;
use Modules\Media\Transformers\MediaGroupTransformer;
use Modules\Users\Transformers\UsersTransformer;

class MediaSystemController extends Controller
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

    public function uploadVideo(){
        $this->validate(request(),[
            'file'=>'required',
            'userId' => 'required',
            'privacy' => 'required',
        ]);

        $media = $this->mediaRepository->uploadVideoMedia(request()->all());

        return transform($media, new MediaTransformer());
    }

    public function uploadPhoto()
    {
        //return response()->json(request()->all());
        // TODO: Change the autogenerated stub
        $this->validate(request(),[
            'file'=>'required',
            'userId' => 'required',
            'privacy' => 'required',
        ]);

        $media = $this->mediaRepository->uploadPhotoViaMedia(request()->all());

        return transform($media, new MediaTransformer());
    }

    public function uploadMusic(){
        $this->validate(request(),[
            'file'=>'required',
            'userId' => 'required',
            'privacy' => 'required',
        ]);

        $media = $this->mediaRepository->uploadMusicMedia(request()->all());
        return transform($media, new MediaTransformer());
    }

    public function uploadUrlViaMedia(){
        $this->validate(request(),[
            'url'=>'required',
            'userId' => 'required',
            'privacy' => 'required',
        ]);

        $media = $this->mediaRepository->saveVideoViaMedia(request()->all());
        return transform($media, new MediaTransformer());
    }

    public function placeMediaIntoCategory($media_id,$cat_id){
        $media=$this->mediaRepository->getMediaById($media_id);
        $this->mediaRepository->placeMedia($media,$cat_id);
        return transform($media, new MediaTransformer());
    }

    public function CreateMediaCategory()
    {
        // TODO: Change the autogenerated stub
        $mediaCategory=$this->mediaRepository->createUserMediaCategory(request()->all());
        return transform($mediaCategory, new MediaGroupTransformer());
    }

    public function getFeaturedPhotos(){
        $media=$this->mediaRepository->getFeaturedPhotos();
        return [
            'photos' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getFeaturedVideos(){
        $media=$this->mediaRepository->getFeaturedVideos();

        return [
            'videos' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getFeaturedMusics(){
        $media=$this->mediaRepository->getFeaturedMusic();
        return [
            'musics' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getMostLikedMusics(){
        $media=$this->mediaRepository->getMostLikedMusics();
        return [
            'musics' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getMostLikedVideos(){
        $media=$this->mediaRepository->getMostLikedVideos();
        return [
            'videos' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getMostLikedPhotos(){
        $media=$this->mediaRepository->getMostLikedPhotos();
        return [
            'photos' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getMostDownloadedMusics(){
        $media=$this->mediaRepository->getMostDownloadedMusics();
        return [
            'musics' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getMostDownloadedPhotos(){
        $media=$this->mediaRepository->getMostDownloadedPhotos();
        return [
            'photos' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getMostDownloadedVideos(){
        $media=$this->mediaRepository->getMostDownloadedVideos();
        return [
            'videos' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getMostSharedMusics(){
        $media=$this->mediaRepository->getMostSharedMusics();
        return [
            'musics' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getMostSharedPhotos(){
        $media=$this->mediaRepository->getMostSharedPhotos();
        return [
            'photos' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getMostSharedVideos(){
        $media=$this->mediaRepository->getMostSharedVideos();
        return [
            'videos' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getOtherMusics(){
        $media=$this->mediaRepository->getOtherMusics();
        return [
            'musics' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getOtherPhotos(){
        $media=$this->mediaRepository->getOtherPhotos();
        return [
            'photos' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getOtherVideos(){
        $media=$this->mediaRepository->getOtherVideos();
        return [
            'videos' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getVideosForCategory($userId,$catName){
        $media=$this->mediaRepository->getCategoryMedias($userId,$catName,2);
        return [
            'videos' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getMusicsForCategory($userId,$catName){
        $media=$this->mediaRepository->getCategoryMedias($userId,$catName,3);
        return [
            'musics' => transform($media->items(), new MediaTransformer()),
            'next_page_url' => $media->nextPageUrl()
        ];
    }

    public function getPhotosForCategory($userId,$catName){
        $medias = $this->mediaRepository->getCategoryMedias($userId,$catName,1);

        return [
            'photos' => transform($medias->items(), new MediaTransformer()),
            'next_page_url' => $medias->nextPageUrl()
        ];
    }

    public function getUserVideoCategory($userId){
        return transform($this->mediaRepository->getUserMediaCategories($userId,2), new MediaGroupTransformer());
    }

    public function getUserMusicCategory($userId){
        return transform($this->mediaRepository->getUserMediaCategories($userId,3), new MediaGroupTransformer());
    }

    public function getUserPhotoCategory($userId){
        return transform($this->mediaRepository->getUserMediaCategories($userId,1), new MediaGroupTransformer());
    }

    public function likeMedia($media_id){
        return $this->mediaRepository->incrementMediaLikes($media_id);
    }

    public function dislikeMedia($media_id){
        return $this->mediaRepository->incrementMediaDislikes($media_id);
    }

    public function downloadMediaCount($media_id){
        return $this->mediaRepository->incrementMediaDownloads($media_id);
    }

    public function shareCount($media_id){
        return $this->mediaRepository->incrementMediaShares($media_id);
    }

    public function viewCount($media_id){
        return $this->mediaRepository->incrementMediaViews($media_id);
    }

    public function featureAMedia($media_id){
        return transform($this->mediaRepository->incrementMediaViews($media_id), new MediaTransformer());

    }

    public function deleteMedia($media_id){
        return transform($this->mediaRepository->DeleteMedia($media_id), new MediaTransformer());
    }

    public function getMedia($media_id){
        return transform($this->mediaRepository->getMediaById($media_id), new MediaTransformer());

    }

    public function makeMediaComment($media_id){
        $this->validate(request(),[
            'media_id' => 'required',
            'sender_id' => 'required',
            'comment' => 'required',
        ]);
        $this->mediaRepository->makeComment(request()->all());
        $media=$this->mediaRepository->getMediaById($media_id);
        return transform($media, new MediaTransformer());
    }

    public function getUserWhoCommented($userId){
        return transform($this->mediaRepository->getUserWhoCommented($userId),new UsersTransformer());
    }

    public function getUnblockedPublicMedias($mediaType)
    {
        if($mediaType==1){
            $medias = $this->mediaRepository->getAllUnblockedPublicPhotos();

            return [
                'photos' => transform($medias->items(), new MediaTransformer()),
                'next_page_url' => $medias->nextPageUrl()
            ];
        }elseif($mediaType==2){
            $medias = $this->mediaRepository->getAllUnblockedPublicVideos();

            return [
                'videos' => transform($medias->items(), new MediaTransformer()),
                'next_page_url' => $medias->nextPageUrl()
            ];
        }else{
            $medias = $this->mediaRepository->getAllUnblockedPublicMusics();

            return [
                'musics' => transform($medias->items(), new MediaTransformer()),
                'next_page_url' => $medias->nextPageUrl()
            ];
        }

    }

}
