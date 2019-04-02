<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\VisitaApiario;
use App\Model\VisitaColmeia;

class VisitaApiarioController extends Controller
{
    private $visitaApiario;

    public function __construct(VisitaApiario $visitaApiario) {
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

    public function visitasByApiario ($id) {

        $visitas = $this->visitaApiario->where('apiario_id', $id)->orderBy('data_visita', 'ASC')->get();

        foreach ($visitas as $visita) {
            $visita->qtd_colmeias_visitadas = \App\Model\VisitaColmeia::where('visita_apiario_id', $visita->id)->count();
        }
        
        return response()->json([
            'message' => 'visitas do apiario de id ',
            'visitas' => $visitas 
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
            'tem_comida'    => 'required|boolean',
            'tem_sombra'    => 'required|boolean',
            'tem_agua'      => 'required|boolean',
            'data_visita'   => 'required|date|after:yesterday',
            'apiario_id'    => 'required|exists:apiarios,id'
        ]);

        $this->visitaApiario = $this->visitaApiario::create($request->all());

        return response()->json([
            'message' => 'Visita realizada no apiario',
            'visitaApiario' => $this->visitaApiario
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function teste(Request $r){
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
