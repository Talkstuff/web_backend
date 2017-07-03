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

Route::group(['prefix'=>'core'], function (){
    Route::group(['prefix'=>'countries'], function(){
        Route::get('/', 'CoreController@getCountries');
        Route::get('{countryId}/states', 'CoreController@getStates');
    });

});


Route::group(['prefix'=>'core','middleware'=>'auth.jwt'], function (){


});