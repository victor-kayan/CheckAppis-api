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

        'apiario' => 'ApiarioController',

        'colmeia' => 'ColmeiaController', 

        'visita/apiario'  => 'VisitaApiarioController',

        'visita/colmeia'  => 'VisitaColmeiaController',

        'intervencao/apiario' => 'IntervencaoController',

        'intervencao/colmeia' => 'IntervencaoColmeiaController',
        
    ]);

    Route::get('apiarios/user', 'ApiarioController@apiariosUserLogado');

    Route::get('colmeias/apiario/{id}', 'ColmeiaController@colmeiasApiario');

    Route::get('visita/apiario/apiario/{id}' , 'VisitaApiarioController@visitasByApiario');

    Route::get('user/apicultores', 'UserController@getAllApicultores');

    Route::get('user/quantidade/colmeias', 'UserController@qtdApiarios');

    Route::get('intervencao/apiario/apiario/{apiario_id}', 'IntervencaoController@indexByApiario');
    Route::get('intervencao/apiario/concluir/{apiario_id}', 'IntervencaoController@concluirIntervencao');

    Route::get('intervencao/colmeia/intervencao/{intervencao_id}', 'IntervencaoColmeiaController@indexByIntervencao');
    Route::get('intervencao/colmeia/concluir/{intervencao_id}', 'IntervencaoColmeiaController@concluirIntervencao');

});