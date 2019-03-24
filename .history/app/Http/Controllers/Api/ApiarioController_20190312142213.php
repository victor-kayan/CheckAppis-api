<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Apiario;

class ApiarioController extends Controller
{
    private $apiario;

    public function __construct(Apiario $apiario)
    {
        $this->apiario = $apiario;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'Lista de apiarios',
            'apiarios' => $this->apiario->all()
        ], 201); 
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
            'nome' => 'required|string',
            'endereco' => 'required|string'
        ]);

        $apiario = [ 
            "nome" => $request->nome,
            "endereco" => $request->endereco,
            "user_id" => $request->user()->id
        ];

        $this->apiario = Apiario::create($apiario);
        
        return response()->json([
            'message' => 'Apiario criado com sucesso',
            'apiario' => $this->apiario
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->apiario = $this->apiario->findOrFail($id);

        return response()->json([
            'message' => 'Detalhes de um apiario',
            'apario' => $this->apiario
        ] , 200);
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
        $this->apiario = $this->apiario->findOrFail($id);

        $this->apiario->update($request->all());

        return response()->json([
            'message' => 'Detalhes de um apiario',
            'apario' => $this->apiario
        ] , 200);  
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
