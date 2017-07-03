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

Route::group(['prefix'=>'posts','middleware'=>'auth.jwt'], function (){
    Route::get('/','PostsController@getAllPosts');

    Route::group(['prefix'=>'{user_id}'], function (){
        Route::post('/','PostsController@saveUserPost');

        Route::get('/','PostsController@fetchUserPosts');

        Route::post('/comments/{comment_id}', 'PostsController@replyComment');


        Route::group(['prefix'=>'post/{post_id}'], function(){
            Route::post('/likes','PostsController@toggleLikePost');
            Route::get('/likes','PostsController@fetchUserLikesOnPost');

            Route::post('/comments', 'PostsController@makeComment');
        });
    });

});
