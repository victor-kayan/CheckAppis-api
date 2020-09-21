<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Apiario;
use App\Model\Colmeia;
use App\Model\VisitaApiario;
use App\Model\VisitaColmeia;
use App\Model\Intervencao;
use App\Model\IntervencaoColmeia;

class OfflineSyncController extends Controller
{
  public function __construct()
  {
    $this->middleware('role:apicultor');
  }

  public function indexMobile(){
    $userId = auth()->user()->id;

    $apiaries = Apiario::where('apicultor_id', $userId)->get(); // Lista de apiários do usuário logado

    $listOfApiariesIds = Array();
    foreach ($apiaries as $apiary) {
      array_push($listOfApiariesIds, $apiary->id);
    }

    $hives = Colmeia::whereIn('apiario_id', $listOfApiariesIds)->get(); // Lista de colmeias do usuário logado
    
    $apiariesInterventions = Intervencao::whereHas('apiario', function ($query) use ($userId) { // Lista de intervenções aos apiários do usuário logado
      $query->where('apicultor_id', $userId);
    })->where('is_concluido', false)->with('apiario')->orderBy('created_at', 'DESC')->get();

    foreach ($apiariesInterventions as $apiaryIntervention) {
      $apiaryIntervention->tecnico = User::find($apiaryIntervention->tecnico_id);
    }

    $hivesInterventions = IntervencaoColmeia::whereHas('colmeia', function ($query) use ($listOfApiariesIds) { // Lista de intervenções às colmeias dos usuário logado
      $query->whereIn('apiario_id', $listOfApiariesIds);
    })->where('is_concluido', false)->with('colmeia.apiario')->orderBy('created_at', 'DESC')->get();

    foreach ($hivesInterventions as $hiveIntervention) {
      $hiveIntervention->tecnico = User::find($hiveIntervention->colmeia->apiario->tecnico_id);
    }

    $visits = VisitaApiario::whereIn('apiario_id', $listOfApiariesIds)  // Lista de visitas do usuário logado
      ->orderBy('created_at', 'DESC')->with('visitaColmeias.colmeia')->get();

    foreach($visits as $visit) {
      $visit->isSynced = true;
    }

    return response()->json([
      'apiarios' => $apiaries,
      'apiarios_count' => $apiaries->count(),
      'colmeias' => $hives,
      'colmeias_count' => $hives->count(),
      'visitas' => $visits,
      'intervencoes_apiarios' => $apiariesInterventions,
      'intervencoes_colmeias' => $hivesInterventions,
      'intervencoes_totais_count' => $apiariesInterventions->count() + $hivesInterventions->count()
    ], 200);
  }  
}