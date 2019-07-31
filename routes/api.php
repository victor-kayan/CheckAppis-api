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
Route::options('{all}', function () {
    return response('ok', 200)
        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With')
        ->header('Access-Control-Allow-Origin', '*');
})->where('all', '.*');

Route::prefix('auth')->group(function () {
    Route::post('login/apicultor', 'AutenticadorControlador@loginApicultor');
    Route::post('login/tecnico', 'AutenticadorControlador@loginTecnico');
    Route::post('login/tecnico/facebook', 'AutenticadorControlador@loginFacebook');

    Route::middleware('auth:api')->group(function () {
        Route::post('registro', 'AutenticadorControlador@registro')->middleware('role:tecnico');
    });
    Route::post('logout', 'AutenticadorControlador@logout');

    Route::post('refreshtoken', 'AutenticadorControlador@refreshToken');
});

Route::middleware('auth:api')->namespace('Api')->group(function () {
    Route::apiResources([
        'user' => 'UserController',
        'apiario' => 'ApiarioController',
        'colmeia' => 'ColmeiaController',
        'visita' => 'VisitaController',
        'intervencao/apiario' => 'IntervencaoController',
        'intervencao/colmeia' => 'IntervencaoColmeiaController',
    ]);

    Route::get('home', 'HomeTecnicoController@index');

    Route::get('cidades/uf/{uf}', 'CidadeController@cidadesByUf');

    Route::get('apicultor/apiarios', 'ApiarioController@apiariosUserLogado');
    Route::get('apicultor/colmeiaswithintervencoes/apiarios', 'ApiarioController@getApiariosWithColmeiasWithIntervencoes');
    Route::get('apiario/{apiario_id}/colmeias', 'ColmeiaController@colmeiasApiario');
    Route::get('apiario/{apiario_id}/visitas', 'VisitaController@visitasByApiario');

    Route::get('tecnico/perfil', 'UserController@getPerfil');

    Route::get('apicultores', 'UserController@getAllApicultores');

    Route::get('apicultor/apiarios/intervencoes', 'IntervencaoController@indexByUserLogged');
    Route::get('intervencao/{intervencao_id}/concluir', 'IntervencaoController@concluirIntervencao');
    Route::get('apiario/{apiario_id}/intervencoes/colmeias', 'IntervencaoColmeiaController@indexByApiario');
    Route::get('intervencao/colmeia/{intervencao_id}/concluir', 'IntervencaoColmeiaController@concluirIntervencao');

    Route::get('apicultor/apiarios/count', 'ApiarioController@countApairosByUser');
    Route::get('apicultor/colmeias/count', 'ColmeiaController@countColmeiasByUser');
    Route::get('apicultor/intervencoes/count', 'IntervencaoController@countIntervencoesByUser');
});
