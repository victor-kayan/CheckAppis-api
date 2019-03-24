<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\Apiario; 
use App\Model\Colmeia;

class UserController extends Controller
{
    // Quem vai poder cadastrar usuários é somente o administrador.
       
    public function __construct()
    {
        $this->middleware('role:tecnico');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'Deu certooo';
    }

    public function getAllApicultores() {

        $apicultores = User::where('tecnico_id', auth()->user()->id)->get();
        $apiarios = null;

        foreach($apicultores as $apicultor){
            $apiarios = Apiario::where('user_id', $apicultor->id)->get();
            $apicultor->qtdApiarios = Apiario::where('user_id', $apicultor->id)->count();
        }

        foreach($apiarios as $apiario) {
            $apicultor->qtdColmeias = Colmeia::where('apiario_id', $apiario->id)->count();
        }

        return "Aqui";

        // return response()->json([
        //     'message' => 'Lista de apicultores',
        //     'apicultores' => $apicultores,
        //     'apiarios' => "Aui"
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
