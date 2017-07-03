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
