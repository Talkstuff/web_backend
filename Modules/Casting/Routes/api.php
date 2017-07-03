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

Route::group(['prefix'=>'casting','middleware'=>'auth.jwt'], function (){
    Route::post('upload-image','CastingController@uploadImage');
    Route::post('upload-headshot-image','CastingController@uploadHeadShotImage');

    Route::post('save-cast','CastingController@submitCast');

});