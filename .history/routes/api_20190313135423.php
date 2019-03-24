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

    Route::post('login', 'AutenticadorControlador@login');

    Route::middleware('auth:api', ['except' => ['login']] )->group(function () {
        Route::post('registro', 'AutenticadorControlador@registro');
        Route::post('logout', 'AutenticadorControlador@logout');
    });

    Route::post('refreshtoken', 'AutenticadorControlador@refreshToken');
});

Route::middleware('auth:api')->namespace('Api')->group(function () {

    Route::apiResources([

        'apiario' => 'ApiarioController',

        'colmeia' => 'ColmeiaController'
        
    ]);
});