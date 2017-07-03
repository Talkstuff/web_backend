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


Route::group(['prefix'=>'staffs','middleware'=>\Modules\Controlpanel\Http\Middleware\CPTokenAuthentication::class], function(){
    Route::get('/', 'StaffsController@getStaffs');
    Route::get('{staff_id}/get', 'StaffsController@fetchStaff');
});
