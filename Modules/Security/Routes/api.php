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

// FRONTEND SECURITY API
Route::group(['prefix'=>'security/talkstuff'], function(){
    Route::post('login','LoginController@jwtLogin');
    Route::any('auth-user','LoginController@getJwtUser');
    Route::any('forgot-password','LoginController@forgotPassword');
    Route::post('reset-password','LoginController@resetPassword');
});


// ADMIN CPANEL
Route::group(['prefix' => 'security','middleware'=>'api'], function(){

    /*Route::group(['prefix'=>'users'], function(){
        Route::get('{username}/search-username', 'UserController@searchUsername');
        Route::get('{email}/search-email', 'UserController@searchEmail');
    });*/

    Route::group(['prefix'=>'roles'], function(){
        Route::get('{roleId}/delete', 'RolesController@deleteRole');
        Route::get('{roleId}/get', 'RolesController@fetchRole');
        Route::post('/save', 'RolesController@saveRole');
        Route::get('/fetch-roles', 'RolesController@fetchRoles');
    });

    Route::group(['prefix'=>'permissions'], function(){


        Route::post('/', 'PermissionsController@savePermission');
        Route::get('/fetch-permissions', 'PermissionsController@fetchPermissions');
        Route::any('{permission_id}/delete-permission', 'PermissionsController@deletePermission');
    });

    Route::post('change-password','UserController@changePassword');

});
