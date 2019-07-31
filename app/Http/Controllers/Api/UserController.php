<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\Apiario;
use App\Model\Colmeia;
use App\Model\Endereco;

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
        $apicultores = User::where('tecnico_id', auth()->user()->id)
            ->with('endereco.cidade')->orderBy('updated_at', 'DESC')->paginate(10);
        $apicultoresDB = $apicultores;

        foreach ($apicultoresDB as $apicultor) {
            $apicultoresDB->apiarios = Apiario::where('apicultor_id', $apicultor->id)->get();
            foreach ($apicultoresDB->apiarios as $apiario) {
                $apicultor->qtdColmeias += Colmeia::where('apiario_id', $apiario->id)->count();
            }
            $apicultor->qtdApiarios = Apiario::where('apicultor_id', $apicultor->id)->count();
        }

        return $apicultores;
    }

    public function getPerfil()
    {
        return response()->json([
            'message' => 'Apicultor',
            'user' => $this->user->findOrFail(auth()->user()->id),
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

    public function updatePerfil(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->user = $this->user->where('id', $id)->with('endereco')->first();
        $this->validarEmail($this->user, $request);

        $request->validate([
            'name' => 'required|max:50',
            'password' => 'required|confirmed|min:6|max:30',
            'email' => 'required|email',
            'telefone' => 'required',
            'cidade_id' => 'required|integer|exists:cidades,id',
            'logradouro' => 'required|max:100',
        ]);

        \DB::transaction(function () use ($request) {
            Endereco::where('id', $this->user->endereco->id)->updateOrCreate([
                'cidade_id' => $request->cidade_id,
                'logradouro' => $request->logradouro,
            ]);

            $this->user->update([
                'name' => $request->name,
                'telefone' => $request->telefone,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        });

        return response()->json([
            'message' => 'Apicultor alterado com sucesso',
            'user' => $this->user,
        ], 200);
    }

    public function destroy($id)
    {
        $this->user->findOrFail($id)->delete();

        return response()->json([
            'message' => 'Apicultor removido com sucesso',
        ], 204);
    }
}
