<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::any('/media/{userId}/upload-profile', 'MediaController@uploadImage');

Route::group(['prefix'=> 'media','middleware'=>'auth.jwt'], function(){

    Route::group(['prefix'=>'{userId}'],function (){
        Route::any('upload-image', 'MediaController@uploadImage');
        Route::any('update-profile', 'MediaController@changeProfileImage');
        Route::any('update-cover', 'MediaController@changeCoverImage');
    });
});

/**
 * =====================================================
 * Godwin's media api
 * needs some more work on the middleware auth
 * =====================================================
 */
Route::group(['prefix'=> 'media'/*,'middleware'=>'auth.jwt'*/], function(){
    Route::group(['prefix'=>'{media_id}'],function (){
        Route::get('/', 'MediaSystemController@getMedia');
        Route::get('/comment/{userId}', 'MediaSystemController@getUserWhoCommented');
        Route::any('/featureMedia', 'MediaSystemController@featureAMedia');
        Route::any('/increaseViews', 'MediaSystemController@viewCount');
        Route::any('/increaseShare', 'MediaSystemController@shareCount');
        Route::any('/dislikeMedia', 'MediaSystemController@dislikeMedia');
        Route::any('/increaseDownload', 'MediaSystemController@downloadMediaCount');
        Route::any('/likeMedia', 'MediaSystemController@likeMedia');
        Route::any('/delete', 'MediaSystemController@deleteMedia');
        Route::post('/commentOnMedia', 'MediaSystemController@makeMediaComment');
    });

    Route::group(['prefix'=>'unblocked'],function (){
        Route::get('/{mediaType}', 'MediaSystemController@getUnblockedPublicMedias');
    });

    Route::group(['prefix'=>'gallery'],function(){
        Route::get('/featured','MediaSystemController@getFeaturedPhotos');
        Route::get('/mostDownloaded','MediaSystemController@getMostDownloadedPhotos');
        Route::get('/mostLiked','MediaSystemController@getMostLikedPhotos');
        Route::get('/mostShared','MediaSystemController@getMostSharedPhotos');
        Route::get('/ ','MediaSystemController@getOtherPhotos');
        Route::group(['prefix'=>'{userId}'],function(){
            Route::get('/','MediaSystemController@getUserPhotoCategory');
            Route::get('/{catName}','MediaSystemController@getPhotosForCategory');
            Route::post('/uploadPhoto','MediaSystemController@uploadPhoto');
        });
    });
    Route::group(['prefix'=>'video'],function(){
        Route::get('/featured','MediaSystemController@getFeaturedVideos');
        Route::get('/mostDownloaded','MediaSystemController@getMostDownloadedVideos');
        Route::get('/mostLiked','MediaSystemController@getMostLikedVideos');
        Route::get('/mostShared','MediaSystemController@getMostSharedVideos');
        Route::get('/others','MediaSystemController@getOtherVideos');
        Route::group(['prefix'=>'{userId}'],function(){
            Route::get('/','MediaSystemController@getUserVideoCategory');
            Route::get('/{catName}','MediaSystemController@getVideosForCategory');
            Route::post('/uploadVideo','MediaSystemController@uploadVideo');
            Route::post('/uploadUrl','MediaSystemController@uploadUrlViaMedia');
        });
    });

    Route::group(['prefix'=>'music'],function(){
        Route::get('/featured','MediaSystemController@getFeaturedMusics');
        Route::get('/mostDownloaded','MediaSystemController@getMostDownloadedMusics');
        Route::get('/mostLiked','MediaSystemController@getMostLikedMusics');
        Route::get('/mostShared','MediaSystemController@getMostSharedMusics');
        Route::get('/others','MediaSystemController@getOtherMusics');
        Route::group(['prefix'=>'{userId}'],function(){
            Route::get('/','MediaSystemController@getUserMusicCategory');
            Route::get('/{catName}','MediaSystemController@getMusicsForCategory');
            Route::post('/uploadMusic','MediaSystemController@uploadMusic');
        });
    });

    Route::group(['prefix'=>'category'], function(){
        Route::post('/create','MediaSystemController@CreateMediaCategory');
    });
});