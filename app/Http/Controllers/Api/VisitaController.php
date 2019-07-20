<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\VisitaApiario;
use App\Model\VisitaColmeia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitaController extends Controller
{
    private $visitaApiario;

    public function __construct(VisitaApiario $visitaApiario)
    {
        $this->visitaApiario = $visitaApiario;
        $this->middleware('role:apicultor');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function visitasByApiario($apiario_id)
    {

        $visitas = $this->visitaApiario->where('apiario_id', $apiario_id)->orderBy('id', 'DESC')->with('visitaColmeias.colmeia')->get();

        foreach ($visitas as $visita) {
            $visita->qtd_colmeias_com_postura = VisitaColmeia::where('visita_apiario_id', $visita->id)->where('tem_postura', true)->count();
            $visita->qtd_colmeias_sem_postura = VisitaColmeia::where('visita_apiario_id', $visita->id)->where('tem_postura', false)->count();

            $visita->qtd_colmeias_com_abelhas_mortas = VisitaColmeia::where('visita_apiario_id', $visita->id)->where('tem_abelhas_mortas', true)->count();
            $visita->qtd_colmeias_sem_abelhas_mortas = VisitaColmeia::where('visita_apiario_id', $visita->id)->where('tem_abelhas_mortas', false)->count();

            $visita->qtd_quadros_mel = VisitaColmeia::where('visita_apiario_id', $visita->id)->where('qtd_quadros_mel', '>', 0)->count();
            $visita->qtd_quadros_polen = VisitaColmeia::where('visita_apiario_id', $visita->id)->where('qtd_quadros_polen', '>', 0)->count();
            $visita->qtd_cria_aberta = VisitaColmeia::where('visita_apiario_id', $visita->id)->where('qtd_cria_aberta', '>', 0)->count();
            $visita->qtd_cria_fechada = VisitaColmeia::where('visita_apiario_id', $visita->id)->where('qtd_cria_fechada', '>', 0)->count();
            $visita->qtd_quadros_analizados = $visita->qtd_quadros_mel + $visita->qtd_quadros_polen + $visita->qtd_cria_aberta + $visita->qtd_cria_fechada;
        }

        return response()->json([
            'message' => 'visitas do apiario',
            'visitas' => $visitas,
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'visitas_colmeias' => 'array',
            'visita_apiario' => 'required',
            'apiario_id' => 'required|exists:apiarios,id',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $this->visitaApiario = VisitaApiario::create(array_merge($request->visita_apiario, ['apiario_id' => $request->apiario_id]));

                if ($this->visitaApiario) {
                    foreach ($request->visitas_colmeias as $visita_colmeia) {
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

        $visita = VisitaApiario::where('id', $this->visitaApiario->id)->with('visitaColmeias.colmeia')->first();

        $this->visitaApiario->qtd_colmeias_com_postura = VisitaColmeia::where('visita_apiario_id', $visita->id)->where('tem_postura', true)->count();
        $this->visitaApiario->qtd_colmeias_sem_postura = VisitaColmeia::where('visita_apiario_id', $visita->id)->where('tem_postura', false)->count();

        $this->visitaApiario->qtd_colmeias_com_abelhas_mortas = VisitaColmeia::where('visita_apiario_id', $visita->id)->where('tem_abelhas_mortas', true)->count();
        $this->visitaApiario->qtd_colmeias_sem_abelhas_mortas = VisitaColmeia::where('visita_apiario_id', $visita->id)->where('tem_abelhas_mortas', false)->count();

        $this->visitaApiario->qtd_quadros_mel = VisitaColmeia::where('visita_apiario_id', $visita->id)->where('qtd_quadros_mel', '>', 0)->count();
        $this->visitaApiario->qtd_quadros_polen = VisitaColmeia::where('visita_apiario_id', $visita->id)->where('qtd_quadros_polen', '>', 0)->count();
        $this->visitaApiario->qtd_cria_aberta = VisitaColmeia::where('visita_apiario_id', $visita->id)->where('qtd_cria_aberta', '>', 0)->count();
        $this->visitaApiario->qtd_cria_fechada = VisitaColmeia::where('visita_apiario_id', $visita->id)->where('qtd_cria_fechada', '>', 0)->count();
        $this->visitaApiario->qtd_quadros_analizados = $this->visitaApiario->qtd_quadros_mel + $this->visitaApiario->qtd_quadros_polen + $this->visitaApiario->qtd_cria_aberta + $this->visitaApiario->qtd_cria_fechada;
        $this->visitaApiario->visita_colmeias = VisitaColmeia::where('visita_apiario_id', $this->visitaApiario->id)->with('colmeia')->get();

        return response()->json([
            'message' => 'Visita regristrada com sucesso',
            'visita' => $this->visitaApiario,
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function teste(Request $r)
    {
        return $r;
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        VisitaColmeia::where('visita_apiario_id', $id)->delete();
        $this->visitaApiario->findOrFail($id)->delete();

        return response()->json([], 204);

    }
}