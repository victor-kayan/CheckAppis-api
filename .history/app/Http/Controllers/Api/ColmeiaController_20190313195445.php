<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Colmeia;
use App\Model\User;
use App\Model\Apiario;

class ColmeiaController extends Controller
{
    private $colmeia;

    public function __construct(Colmeia $colmeia){
        $this->colmeia = $colmeia;
        $this->middleware('role:apicultor');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->colmeia = $this->colmeia->all();

        return $this->colmeia;
        // $user = User::findOrFail(auth()->user()->id);

        // $apiarios = Apiario::where('user_id', $user->id)->get();

        

        // return response()->json([
        //     'message' => 'Lista de colmeias',
        //    // 'colmeias' => $this->colmeia->where('user_id', auth()->user()->id)
        // ], 200);
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
            'descricao' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'apiario_id' => 'required|exists:apiario,id'

        ]);

        $this->colmeia = $this->colmeia::create($request->all());

        return $colmeia;

        return response()->json([
            'message' => 'Colmeia criada com sucesso',
            'apiario' => $this->colmeia
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
