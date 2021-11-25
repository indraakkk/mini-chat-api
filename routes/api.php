<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function () {
    Route::group(['prefix' => 'v1'], function() {
        Route::post('/login', 'ChatController@loginOrCreate');
        Route::post('/create', 'ChatController@createChat');
        Route::post('/send', 'ChatController@sendChat');
        Route::get('/list/{uuid}', 'ChatController@listUserRooms');
        Route::post('/chats', 'ChatController@listUserChat');
    });
});
