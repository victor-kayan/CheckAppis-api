<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\Apiario;
use App\Model\Colmeia;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('role:tecnico');
    }

    public function getAllApicultores()
    {
        $apicultores = User::where('tecnico_id', auth()->user()->id)->orderBy('updated_at', 'DESC')->paginate(10);
        $apicultoresDB = $apicultores;

        foreach ($apicultoresDB as $apicultor) {
            $apicultoresDB->apiarios = Apiario::where('user_id', $apicultor->id)->get();
            foreach ($apicultoresDB->apiarios as $apiario) {
                $apicultor->qtdColmeias += Colmeia::where('apiario_id', $apiario->id)->count();
            }
            $apicultor->qtdApiarios = Apiario::where('user_id', $apicultor->id)->count();
        }

        return $apicultores;
    }

    public function show($id)
    {
        return response()->json([
            'message' => 'Apicultor',
            'apicultor' => $this->user->findOrFail($id),
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $this->user = $this->user->findOrFail($id);
        $this->validarEmail($this->user, $request);

        $request->validate([
            'name' => 'required|max:50',
            'password' => 'required|min:6|max:30',
            'email' => 'required|email',
        ]);

        $this->user->update($request->all());

        return response()->json([
            'message' => 'Usuário editado com sucesso',
            'user' => $this->user,
        ], 200);
    }

    public function validarEmail($user, $request)
    {
        if ($user->email != $request->email) {
            $request->validate([
                'email' => 'required|email|unique:users,email',
            ]);
        }
    }

    public function destroy($id)
    {
        $this->user->findOrFail($id)->delete();

        return response()->json([
            'message' => 'Apicultor removido com sucesso',
        ], 204);
    }
}
