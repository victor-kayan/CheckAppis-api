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

    //Route::post('login', 'AutenticadorControlador@login');

    Route::middleware('auth:api')->group(function () {
        //Rota protegida pelo middleware de role, onde so quem tiver tiver a permissão de tecnico poderá executar.
        Route::post('registro', 'AutenticadorControlador@registro')->middleware('role:tecnico');
        Route::post('logout', 'AutenticadorControlador@logout');
    });

    Route::post('refreshtoken', 'AutenticadorControlador@refreshToken');
});

Route::middleware('auth:api')->namespace('Api')->group(function () {

    Route::apiResources([

        'apiario' => 'ApiarioController',

        'colmeia' => 'ColmeiaController'
        
    ]);

    Route::get('apiarios/user', 'ApiarioController@apiariosUserLogado');

    Route::get('apiario/{id}/colmeias', 'ApiarioController@apiarioColmeias');

});