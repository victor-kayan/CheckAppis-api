<?php

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

Route::prefix('auth')->group(function () {

    Route::post('login/apicultor', 'AutenticadorControlador@loginApicultor');
    Route::post('login/tecnico', 'AutenticadorControlador@loginTecnico');

    Route::middleware('auth:api')->group(function () {
        //Rota protegida pelo middleware de role, onde so quem tiver tiver a permissão de tecnico poderá executar.
        Route::post('registro', 'AutenticadorControlador@registro')->middleware('role:tecnico');
        Route::post('logout', 'AutenticadorControlador@logout');
    });

    Route::post('refreshtoken', 'AutenticadorControlador@refreshToken');
});

Route::middleware('auth:api')->namespace('Api')->group(function () {

    Route::apiResources([

        'user' => "UserController",

        'apiario' => 'ApiarioController',

        'colmeia' => 'ColmeiaController',

        'visita' => 'VisitaController',

        'intervencao/apiario' => 'IntervencaoController',

        'intervencao/colmeia' => 'IntervencaoColmeiaController',

    ]);

    Route::get('apiarios/user', 'ApiarioController@apiariosUserLogado');

    Route::get('apiario/{apiario_id}/colmeias', 'ColmeiaController@colmeiasApiario');

    Route::get('apiario/{apiario_id}/visitas', 'VisitaController@visitasByApiario');

    Route::get('apicultores', 'UserController@getAllApicultores');

    Route::get('intervencoes/user', 'IntervencaoController@indexByUserLogged');
    Route::get('intervencao/{intervencao_id}/concluir', 'IntervencaoController@concluirIntervencao');

    Route::get('apiario/{apiario_id}/intervencoes/colmeias', 'IntervencaoColmeiaController@indexByApiario');
    Route::get('intervencao/colmeia/{intervencao_id}/concluir', 'IntervencaoColmeiaController@concluirIntervencao');
});
