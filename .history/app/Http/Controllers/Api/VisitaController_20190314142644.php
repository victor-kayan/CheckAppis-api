<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Visita;

class VisitaController extends Controller
{
    private $visita;

    public function __construct(Visita $visita) {
        $this->visita = $visita;
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
            'visitas' => Visita::all()->with('colmeia')
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
            'temComida'        => 'required|boolean',
            'temSombra'   => 'required|boolean',
            'temAgua'    => 'required|boolean',
            'temAbelhasMortas'   => 'required|boolean',
            'qtdQuadrosMel'  => 'required|integer|min:0',
            'qtdQuadrosPolen'  => 'required|integer|min:0',
            'qtdCriaAberta'  => 'required|integer|min:0',
            'qtdCriaFechada'  => 'required|integer|min:0',
            'data_visita'  => 'required',

        ]);
        
        $this->visita = $this->visita::create( $request->all() );

        return response()->json([
            'message' => 'Visita realizada com sucesso',
            'visita' => $this->visita
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
