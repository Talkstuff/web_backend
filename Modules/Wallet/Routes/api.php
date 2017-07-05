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
Route::group(['prefix'=>'wallets'], function (){
    Route::get('/','WalletsController@getWallets');
    Route::get('{id}/find_wallet','WalletsController@findWallet');

    Route::group(['prefix'=>'create'], function(){
        Route::post('/','WalletsController@createWallet');
    });


    Route::group(['prefix'=>'{id}'], function(){
        Route::get('/','WalletsController@findWallet');
        Route::get('/deposits','WalletsController@getWalletDeposits');

        Route::group(['prefix'=>'deposit'],function(){
            Route::post('/create','DepositsController@createDeposit');
        });
    });
});
