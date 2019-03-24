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
        ], 201); 
    }

    public function apiariosUserLogado (Request $request) {

        $this->apiario = $this->apiario->where('user_id', $request->user()->id)->get();

        // if($this->apiario === null){
        //     abort(404, 'Not we found apiarios for this user')
        // }

        return response()->json([
            'message' => 'Lista de apiarios',
            'apiarios' =>  $this->apiario
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
            'endereco' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);

        $this->apiario = Apiario::create([
            'nome'       => $request->nome,
            'endereco'   => $request->endereco,
            'user_id'    => $request->user_id,
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
        $this->apiario = $this->apiario
                ->where('id', $id)
                ->where('tecnico_id', auth()->user()->id)
                ->first();

        if($this->apiario === null){
            abort(404, 'Not found apiario id');
        }
        
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
        $this->apiario = $this->apiario
                ->where('id', $id)
                ->where('tecnico_id', auth()->user()->id)
                ->first();

        return $this->apiario
        ->where('id', $id)
        ->where('tecnico_id', auth()->user()->id)
        ->first();
      
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
        $this->apiario = $this->apiario->findOrFail($id);

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
