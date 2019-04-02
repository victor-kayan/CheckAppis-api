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
    private $user;
       
    public function __construct(User $user)
    {
        $this->user = $user;
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
        $apicultoresDB = $apicultores;

        foreach($apicultoresDB as $apicultor){
            $apicultoresDB->apiarios = Apiario::where('user_id', $apicultor->id)->get();
            foreach($apicultoresDB->apiarios as $apiario) {
                $apicultor->qtdColmeias += Colmeia::where('apiario_id', $apiario->id)->count();
            }
            $apicultor->qtdApiarios = Apiario::where('user_id', $apicultor->id)->count();
        }

        return response()->json([
            'message' => 'Lista de apicultores',
            'apicultores' => $apicultores,
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
        return "Aquiiiiiiiiii";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user = $this->user->findOrFail($id);                 

        $deleted = $this->user->delete();

        if ($deleted) {
            return response()->json([], 204);
        } else {
            return response()->json([
                'error' => 'Recurso não pode ser excluido',
            ], 500);
        }
    }
}
