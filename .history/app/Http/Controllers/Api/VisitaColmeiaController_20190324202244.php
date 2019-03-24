<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\VisitaColmeia;

class VisitaColmeiaController extends Controller
{
    private $visitaColmeia;

    public function __construct(VisitaColmeia $visitaColmeia) {
        $this->visitaColmeia = $visitaColmeia;
        $this->middleware('role:apicultor', ['except' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->visita = $this->visita->all();

        return response()->json([
            'message' => 'Lista de visitas nas colmeias do user logado',
            'visitas' => VisitaColmeia::with('colmeia')->where('id', 1)->get()
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $request->validate([
            'tem_abelhas_mortas'   => 'required|boolean',
            'qtd_quadros_mel'  => 'required|integer|min:0',
            'qtd_quadros_polen'  => 'required|integer|min:0',
            'qtd_cria_aberta'  => 'required|integer|min:0',
            'qtd_cria_fechada'  => 'required|integer|min:0',
            'colmeia_id' => 'required|integer',
            'data_visita'  => 'required',
            'tem_postura'  => 'required',
            'visita_apiario_id' => 'required|integer'
        ]);

        $isVisitada = $this->visitaColmeia::where('visita_apiario_id', $request->visita_apiario_id)->where('colmeia_id', $request->colmeia_id)->first();

        if($isVisitada){
            $this->visitaColmeia = $this->visitaColmeia::update($request->all());
        }
        else{
            $this->visitaColmeia = $this->visitaColmeia::create($request->all());
        }
        // return $request->qtd_cria_aberta;
        

        return response()->json([
            'message' => 'Visita realizada com sucesso',
            'visita' => $this->visitaColmeia
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        //
    }
}
