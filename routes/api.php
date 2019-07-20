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
<<<<<<< HEAD
        'colmeia' => 'ColmeiaController',
        'visita/apiario' => 'VisitaApiarioController',
        'visita/colmeia' => 'VisitaColmeiaController',
=======

        'colmeia' => 'ColmeiaController', 

        'visita/apiario'  => 'VisitaController',

>>>>>>> c9c2dfc9bb7912b0b8a46b4600c2dd6fea3e0ff5
        'intervencao/apiario' => 'IntervencaoController',
        'intervencao/colmeia' => 'IntervencaoColmeiaController',
    ]);

    Route::get('home', 'HomeTecnicoController@index');

    Route::get('cidades/uf/{uf}', 'CidadeController@cidadesByUf');

    Route::get('apiarios/user', 'ApiarioController@apiariosUserLogado');

    Route::get('colmeias/apiario/{id}', 'ColmeiaController@colmeiasApiario');

<<<<<<< HEAD
=======
    Route::get('visita/apiario/apiario/{id}' , 'VisitaController@visitasByApiario');

>>>>>>> c9c2dfc9bb7912b0b8a46b4600c2dd6fea3e0ff5
    Route::get('apicultores', 'UserController@getAllApicultores');

    Route::get('intervencoes/user', 'IntervencaoController@indexByUserLogged');
    Route::get('intervencao/apiario/concluir/{apiario_id}', 'IntervencaoController@concluirIntervencao');
    Route::get('intervencao/colmeia/intervencao/{intervencao_id}', 'IntervencaoColmeiaController@indexByIntervencao');
    Route::get('intervencao/colmeia/concluir/{intervencao_id}', 'IntervencaoColmeiaController@concluirIntervencao');
<<<<<<< HEAD

    Route::get('visitas/colmeias/visita/apiario/{visita_apiario_id}', 'VisitaColmeiaController@visitasColmeiasByVisitaApiario');
    Route::get('visita/apiario/apiario/{id}', 'VisitaApiarioController@visitasByApiario');
});
=======
});
>>>>>>> c9c2dfc9bb7912b0b8a46b4600c2dd6fea3e0ff5
