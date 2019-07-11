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

    public function visitasByApiario($id)
    {

        $visitas = $this->visitaApiario->where('apiario_id', $id)->orderBy('created_at', 'ASC')->with('visitaColmeias')->get();

        foreach ($visitas as $visita) {
            $visita->qtd_colmeias_visitadas = VisitaColmeia::where('visita_apiario_id', $visita->id)->count();
        }

        return response()->json([
            'message' => 'visitas do apiario',
            'visitas' => $visitas,
        ]);
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

        return response()->json([
            'message' => 'Visita regristrada com sucesso',
            'visita' => VisitaApiario::where('id', $this->visitaApiario->id)->with('visitaColmeias')->first(),
        ]);
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
