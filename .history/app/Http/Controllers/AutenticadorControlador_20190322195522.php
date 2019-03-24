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

        return $request. "Aq8i";
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
            'tecnico_id' => auth()->user()->id
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

    public function loginApicultor(Request $request) {

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

        $request->user()->authorizeRoles(['apicultor']);

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 200); 
    }

    public function loginTecnico(Request $request) {

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

        $request->user()->authorizeRoles(['tecnico']);

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 200); 
    }

    // public function verificarCredenciais(Request $request) {
    //     $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string'
    //     ]);

    //     $credenciais = [
    //         'email' => $request->email,
    //         'password' => $request->password
    //     ];

    //     //A função attemp retorn true ou false
    //     if (!Auth::attempt($credenciais))
    //         return response()->json([
    //             'message' => 'Acesso negado'
    //         ], 401);
            
    //     $user = $request->user();
    //     // AccessToken retorna uma string com o token
    //     $token = $user->createToken('Token de acesso')->accessToken;

    //     return 
    // }

    public function logout(Request $request) {
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