<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Welcome;
use App\Model\User;
use App\Model\Role;

class AutenticadorControlador extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login']]);
    // }

    public function registro(Request $request) {
        //Verifique se o tecnico está loagado para poder fazer o cadastro de novos apicultores
        //$request->user()->authorizeRoles(['tecnico']);
      
        //Nome email e senha
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user  = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        //Adicionando role de apicultor para o usuário.
        $user->roles()->attach(Role::where('name', 'apicultor')->first());

        // try{
        //     $user->notify(new Welcome($user));        
        // }catch(\Exception $e){
        //     print($e);
        // }

        return response()->json([
            'message' => 'Usuario criado com sucesso'
        ], 201);
    }

    public function login(Request $request) {

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credenciais = [
            'email' => $request->email,
            'password' => $request->password
        ];

        //A função attemp retorn true ou false
        if (!Auth::attempt($credenciais))
            return response()->json([
                'message' => 'Acesso negado'
            ], 401);
            
        $user = $request->user();
        // AccessToken retorna uma string com o token
        $token = $user->createToken('Token de acesso')->accessToken;

        return response()->json([
            'token' => $token
        ], 200); 
    }

    public function logout(Request $request) {
        //Fazendo isso o token de acesso perde a validade.
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Deslogado com sucesso'
        ]);
    }

    // public function ativarregistro($id, $token){
    //     $user = User::find($id);
    //     if($user){
    //         if($user->token == $token) {
    //             $user->active = true;
    //             $user->token = '';
    //             $user->save();
    //             return view('registroativo');
    //         }
    //     }
    //     return view('registroerro');
    // }
}