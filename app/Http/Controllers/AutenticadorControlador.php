<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\User;
use App\Model\Role;
use Socialite;

class AutenticadorControlador extends Controller
{
    public function registro(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:6|max:30',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'tecnico_id' => auth()->user()->id,
        ]);

        $user->roles()->attach(Role::where('name', 'apicultor')->first());

        return response()->json([
            'message' => 'Usuario criado com sucesso',
        ], 201);
    }

    public function loginApicultor(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credenciais = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credenciais)) {
            return response()->json([
                'message' => 'Acesso negado',
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('Token de acesso')->accessToken;

        $request->user()->authorizeRoles(['apicultor']);

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 200);
    }

    public function loginTecnico(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credenciais = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credenciais)) {
            return response()->json([
                'message' => 'Acesso negado',
            ], 401);
        }

        $user = $request->user();

        $token = $user->createToken('Token de acesso')->accessToken;
        $request->user()->authorizeRoles(['tecnico']);

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 200);
    }

    public function loginFacebook(Request $request)
    {
        $request->validate([
            'token' => 'required',
        ]);

        $user = $this->verificarTokenFacebook($request->token);
        $user_db = User::where('email', $user->email)->first();

        if (!$user_db) {
            $this->validarEmail($user->email);
            $url = $user->avatar_original;
            $diretorio = public_path().'/images/usuarios/'.time().str_replace(' ', null, $user->name).'.png';
            copy($url, $diretorio);

            $user_db = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'foto' => env('APP_URL').str_replace(public_path(), null, $diretorio),
                ]);

            $role_tecnico = Role::where('name', 'tecnico')->first();
            $user_db->roles()->attach($role_tecnico);
        }

        $token = $user_db->createToken('Token de acesso')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user_db,
        ], 200);
    }

    public function verificarTokenFacebook($token)
    {
        try {
            $user = Socialite::driver('facebook')->userFromToken($token);
        } catch (\Exception $e) {
            abort(401, $e->getMessage());
        }

        return $user;
    }

    public function validarEmail($email)
    {
        $user_db = User::where('email', $email)->first();

        if ($user_db) {
            abort(422, 'O campo email já está sendo utilizado por outro usuário');
        }

        if ($email == null) {
            abort(422, 'Infelizmente não conseguimos pegar seu email do facebook');
        }

        return null;
    }

    public function logout(Request $request)
    {
        //$request->user()->token()->revoke();

        return response()->json([
            'message' => 'Deslogado com sucesso',
        ]);
    }
}
