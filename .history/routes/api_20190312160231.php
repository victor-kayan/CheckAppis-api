<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('auth')->group(function () {

    Route::post('registro', 'AutenticadorControlador@registro');

    Route::post('login', 'AutenticadorControlador@login');

    Route::middleware('auth:api')->group(function () {
        Route::post('logout', 'AutenticadorControlador@logout');
    });

    Route::post('refreshtoken', 'AutenticadorControlador@refreshToken');
});

Route::middleware('auth:api', 'throttle:5')->namespace('Api')->group(function () {

    /**
     * Rotas para Apiario
     */
    Route::resource('apiario', 'ApiarioController')
    // Route::get('apiario/list', 'ApiarioController@index');
    // Route::get('apiario/show/{id}', 'ApiarioController@show');
    // Route::post('apiario/save', 'ApiarioController@store');
    // Route::put('apiario/edit/{id}', 'ApiarioController@update');
    // Route::delete('apiario/destroy/{id}', 'ApiarioController@destroy');

    /**
     * Rotas para Colmeias
     */
    Route::get('colmeia/list', 'ColmeiaController@index');
});