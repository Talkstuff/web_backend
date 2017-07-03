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
Route::group(['prefix' => 'controlpanel','middleware'=>\Modules\Controlpanel\Http\Middleware\CPTokenAuthentication::class], function(){

    Route::group(['prefix'=>'modules'], function(){
        Route::get('/','ModulesController@fetchModules');
        Route::post('install-module','ModulesController@installModule');
    });

});
