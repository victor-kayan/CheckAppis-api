<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Colmeia;

class ColmeiaController extends Controller
{
    private $colmeia;

    public function __construct(Colmeia $colmeia){
        $this->colmeia = $colmeia;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'Lista de colmeias',
            'colmeias' => $this->colmeia->all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'nome' => 'required|string',
        //     'descricao' => 'required|string',
        //     'latitude' => 'required',
        //     'longitude' => 'required',
        //     'apiario_id' => 'required'
        // ]);

        // $colmeia = [ 
        //     "nome" => $request->nome,
        //     "endereco" => $request->endereco,
        //     "user_id" => $request->user()->id
        // ];

        // $this->apiario = Apiario::create($apiario);
        
        // return response()->json([
        //     'message' => 'Apiario criado com sucesso',
        //     'apiario' => $this->apiario
        // ], 201);
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
