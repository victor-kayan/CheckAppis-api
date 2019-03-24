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
        $request->validate([
            'tem_abelhas_mortas'   => 'required|boolean',
            'qtd_quadros_mel'  => 'required|integer|min:0',
            'qtd_quadros_polen'  => 'required|integer|min:0',
            'qtd_cria_aberta'  => 'required|integer|min:0',
            'qtd_cria_fechada'  => 'required|integer|min:0',
            'data_visita'  => 'required',
        ]);
        
        $this->visitaColmeia = $this->visitaColmeia::create( $request->all() );

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
