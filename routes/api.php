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


Route::middleware(['cors'])->group(function () {
    Route::middleware(['auth:api'])->group(function() {
        Route::get('/user', 'UserController@user');
        Route::get('/user/token', 'UserController@token');
    
        Route::get('/test', 'ClothesController@test');
        Route::get('/clothes/get', 'ClothesController@index');
        Route::post('/clothes/add', 'ClothesController@add');
        Route::put('/clothes/update/{id}', 'ClothesController@update');
        Route::get('/clothes/{id}/coordinations', 'ClothesController@clothesCoordinations');
        Route::get('/tag/all', 'TagController@index');
        Route::get('/coordination/get', 'CoordinationController@index');
        Route::post('/coordination/add', 'CoordinationController@add');
        Route::get('/share', 'ShareCodeController@show');
        Route::post('/share/add', 'ShareCodeController@add');
        Route::get('/share/users', 'ShareCodeController@shareUser');
        Route::delete('/share/delete', 'ShareCodeController@delete');
    //Route::get('/share?code={code}', 'ClothesController@shareCloset');
    
    }); //ログイン済み可能

    Route::group(['prefix' => '/auth', ['middleware' => 'throttle:20,5']], function () {
        Route::get('/login/guest', 'LoginController@guestLogin');
        Route::get('/login/{service}', 'SocialLoginController@redirect');
        Route::get('/login/{service}/callback', 'SocialLoginController@callback');
    });
});







