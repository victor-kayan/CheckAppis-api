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

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $this->user = $this->user->findOrFail($id);

        return response()->json([
            'message' => 'Apicultor',
            'apicultor'    => $this->user
        ], 200);
    }

    public function update(Request $request, $id)
    {
        //$this->user = $this->user->findOrFail($id);
        return $request->all();

        $request->validate([
            'name'      => 'required',
            'password'  => 'required|confirm',
            'email'     => 'required|email',
        ]);

        $this->user->update($request->all());

        return response()->json([
            'message' => 'Usuário editado com sucesso',
            'user'    => $this->user
        ], 200);
    }

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
