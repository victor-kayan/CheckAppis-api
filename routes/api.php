<?php

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
        'visita/colmeia' => 'VisitaColmeiaController',
        'visita/apiario' => 'VisitaController',

        'intervencao/apiario' => 'IntervencaoController',
        'intervencao/colmeia' => 'IntervencaoColmeiaController',
    ]);

    Route::get('home', 'HomeTecnicoController@index');

    Route::get('cidades/uf/{uf}', 'CidadeController@cidadesByUf');

    Route::get('apiarios/user', 'ApiarioController@apiariosUserLogado');

    Route::get('colmeias/apiario/{id}', 'ColmeiaController@colmeiasApiario');

    Route::get('visita/apiario/apiario/{id}', 'VisitaController@visitasByApiario');

    Route::get('apicultores', 'UserController@getAllApicultores');

    Route::get('tecnico/perfil', 'UserController@getPerfil');

    Route::get('intervencoes/user', 'IntervencaoController@indexByUserLogged');
    Route::get('intervencao/apiario/concluir/{apiario_id}', 'IntervencaoController@concluirIntervencao');
    Route::get('intervencao/colmeia/intervencao/{intervencao_id}', 'IntervencaoColmeiaController@indexByIntervencao');
    Route::get('intervencao/colmeia/concluir/{intervencao_id}', 'IntervencaoColmeiaController@concluirIntervencao');
});
