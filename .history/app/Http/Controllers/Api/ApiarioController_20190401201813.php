<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Apiario;
use App\Model\Colmeia;

class ApiarioController extends Controller
{
    private $apiario;

    public function __construct(Apiario $apiario)
    {
        $this->apiario = $apiario;
        $this->middleware('role:tecnico', ['except' => ['apiariosUserLogado']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->apiario = $this->apiario->where('tecnico_id', auth()->user()->id)->get();

        return response()->json([
            'message' => 'Lista de apiarios',
            'apiarios' => $this->apiario
        ], 200); 
    }

    public function apiariosUserLogado () {

        $this->apiario = $this->apiario->where('user_id', auth()->user()->id)->with('colmeias')->get();

        return response()->json([
            'message' => 'Lista de apiarios',
            'apiarios' =>  $this->apiario
        ], 200); 
    }

    // public function apiarioColmeias($id){

    //     $colmeias = Colmeia::where('apiario_id', $id)->get();

    //     return response()->json([
    //         'message' => 'Lista de colmeias do apiario '.$id,
    //         'colmeias' => $colmeias
    //     ], 200);
    // }

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
            'endereco' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $this->apiario = Apiario::create([
            'nome'       => $request->nome,
            'endereco'   => $request->endereco,
            'user_id'    => $request->user_id,
            'latitude'   => $request->latitude,
            'longitude'  => $request->longitude,
            'tecnico_id' => $request->user()->id 
        ]);
     
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
        $this->apiario = $this->apiario->findApiario($id);

        return response()->json([
            'message' => 'Detalhes de um apiario',
            'apiario' => $this->apiario
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
        return $request;
        //Metodo findApiario, busca o apiario pertencente ao userLogado e e verifica o id que veio na requisição.
        $this->apiario = $this->apiario->findApiario($id);

        $request->validate([
            'nome' => 'required|string',
            'endereco' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $this->apiario->update($request->all());
        
        return response()->json([
            'message' => 'Apiario editado',
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
        $this->apiario = $this->apiario->findApiario($id);                       

        $deleted = $this->apiario->delete();

        if ($deleted) {
            return response()->json([], 204);
        } else {
            return response()->json([
                'error' => 'Recurso não pode ser excluido',
            ], 500);
        }
    }
    
}