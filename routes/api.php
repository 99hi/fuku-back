<?php

use App\Http\Controllers\ClothesController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['cors'])->group(function () {
    Route::get('/test', 'ClothesController@test');
    Route::get('/clothes/get', 'ClothesController@index');
    Route::post('/clothes/add', 'ClothesController@add');
    Route::put('/clothes/update/{id}', 'ClothesController@update');
    Route::get('/clothes/{id}/coordinations', 'ClothesController@clothesCoordinations');

    Route::get('/tag/all', 'TagController@index');

    Route::get('/coordination/get', 'CoordinationController@index');
    Route::post('/coordination/add', 'CoordinationController@add');
});
/*
Route::group(['prefix' => '/auth', ['middleware' => 'throttle:20,5']], function () {
    Route::get('/login/{service}', 'SocialLoginController@redirect');
    Route::get('/login/{service}/callback', 'SocialLoginController@callback');
});
*/
