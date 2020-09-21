<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\VisitaApiario;
use App\Model\VisitaColmeia;
use Illuminate\Http\Request;

class VisitaController extends Controller
{
    private $visitaApiario;
    private $visitaColmeia;

    public function __construct(VisitaApiario $visitaApiario, VisitaColmeia $visitaColmeia)
    {
        $this->visitaApiario = $visitaApiario;
        $this->visitaColmeia = $visitaColmeia;
        $this->middleware('role:apicultor', ['except' => ['indexVisitaApiarios', 'indexVisitaColmeias', 'destroyVisitaApiario']]);
    }

    public function indexVisitaApiarios()
    {
        $visitas = $this->visitaApiario->whereHas('apiario', function ($query) {
            $query->where('tecnico_id', auth()->user()->id);
        })->with('apiario')->paginate(10);

        return $visitas;
    }

    public function indexVisitaColmeias()
    {
        $visitas = $this->visitaColmeia->whereHas('colmeia', function ($query) {
            $query->whereHas('apiario', function ($query) {
                $query->where('tecnico_id', auth()->user()->id);
            });
        })->with('colmeia.apiario')->paginate(10);

        return $visitas;
    }

    public function visitasByApiario($apiario_id)
    {
        $visitas = $this->visitaApiario->where('apiario_id', $apiario_id)
            ->orderBy('id', 'DESC')->with('visitaColmeias.colmeia')->get();
        
        foreach($visitas as $visita) {
            $visita->isSynced = true;
        }

        return response()->json([
            'message' => 'visitas do apiario',
            'visitas' => $visitas,
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'visita_colmeias' => 'array',
            'apiario_id' => 'required|exists:apiarios,id',
        ]);

        $visita = $request->visita;

        $dadosVisitaApiario = array(
            'tem_agua' => $request['tem_agua'], 
            'tem_sombra' => $request['tem_sombra'], 
            'tem_comida' => $request['tem_comida'], 
            'apiario_id' => $request['apiario_id'], 
            'observacao' => $request['observacao'],
            'qtd_quadros_mel' => $request['qtd_quadros_mel'], 
            'qtd_quadros_polen' => $request['qtd_quadros_polen'], 
            'qtd_cria_aberta' => $request['qtd_cria_aberta'], 
            'qtd_cria_fechada' => $request['qtd_cria_fechada'], 
            'qtd_quadros_vazios' => $request['qtd_quadros_vazios'],
            'qtd_colmeias_com_postura' => $request['qtd_colmeias_com_postura'], 
            'qtd_colmeias_com_abelhas_mortas' => $request['qtd_colmeias_com_abelhas_mortas'], 
            'qtd_colmeias_com_zangao' => $request['qtd_colmeias_com_zangao'], 
            'qtd_colmeias_com_realeira' => $request['qtd_colmeias_com_realeira'],
            'qtd_colmeias_sem_postura' => $request['qtd_colmeias_sem_postura'], 
            'qtd_colmeias_sem_abelhas_mortas' => $request['qtd_colmeias_sem_abelhas_mortas'], 
            'qtd_colmeias_sem_zangao' => $request['qtd_colmeias_sem_zangao'], 
            'qtd_colmeias_sem_realeira' => $request['qtd_colmeias_sem_realeira'],
            'qtd_quadros_analizados' => $request['qtd_quadros_analizados']
        );

        try {
            DB::transaction(function () use ($dadosVisitaApiario, $request) {
                $this->visitaApiario = VisitaApiario::create($dadosVisitaApiario);

                if ($this->visitaApiario) {
                    foreach ($request['visita_colmeias'] as $visita_colmeia) {
                        VisitaColmeia::create(array_merge($visita_colmeia, ['visita_apiario_id' => $this->visitaApiario->id]));
                    }
                }
            });
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'falha ao registrar visita',
                'error' => $th,
            ], 403);
        }

        $this->visitaApiario->visita_colmeias = VisitaColmeia::where('visita_apiario_id', $this->visitaApiario->id)->with('colmeia')->get();
        $this->visitaApiario->uuid = $request->uuid;
        $this->visitaApiario->isSynced = true;

        return response()->json([
            'message' => 'Visita registrada com sucesso',
            'visita' => $this->visitaApiario,
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroyVisitaApiario($id)
    {
        $this->visitaApiario->findOrFail($id)->delete();

        return response()->json([], 204);
    }
}
