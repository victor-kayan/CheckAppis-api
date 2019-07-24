<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\Model\User;
use App\Model\PasswordReset;
use Validator;

class PasswordResetController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'tipo_user' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Não conseguimos encontrar um usuário com esse endereço de e-mail.',
            ], 404);
        }
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            ['email' => $user->email, 'token' => str_random(60)]
        );
        if ($user && $passwordReset) {
            $user->notify(
                new PasswordResetRequest($passwordReset->token, $request->tipo_user));
        }

        return response()->json([
            'message' => 'Enviamos uma mensagem para o seu email com um link de redefinição de senha!',
        ]);
    }

    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset) {
            return view('auth.passwords.error');
        }
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();

            return view('auth.passwords.error');
        }

        return response()->json($passwordReset);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|min:5',
            'password' => 'required|string|confirmed',
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email],
        ])->first();
        if (!$passwordReset) {
            return view('auth.passwords.error');
        }
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user) {
            return view('auth.passwords.error');
        }
        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        $user->notify(new PasswordResetSuccess($passwordReset));

        return view('auth.passwords.success');
    }

    public function reset_gestor(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string',
        ]);
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email],
        ])->first();
        if (!$passwordReset) {
            return response()->json([
                'message' => 'Este token de redefinição de senha é inválido.',
            ], 404);
        }
        $user_gestor = UserGestor::where('email', $passwordReset->email)->first();
        if (!$user_gestor) {
            return response()->json([
                'message' => 'Não podemos encontrar um usuário com esse endereço de e-mail.',
            ], 404);
        }
        $user_gestor->password = bcrypt($request->password);
        $user_gestor->save();
        $passwordReset->delete();
        $user_gestor->notify(new PasswordResetSuccess($passwordReset));

        return response()->json($user_gestor);
    }

    public function reset_estabelecimento(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token' => 'required|string',
        ]);
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email],
        ])->first();
        if (!$passwordReset) {
            return response()->json([
                'message' => 'Este token de redefinição de senha é inválido.',
            ], 404);
        }
        $user_estabelecimento = UserEstabelecimento::where('email', $passwordReset->email)->first();
        if (!$user_estabelecimento) {
            return response()->json([
                'message' => 'Não podemos encontrar um usuário com esse endereço de e-mail.',
            ], 404);
        }
        $user_estabelecimento->password = bcrypt($request->password);
        $user_estabelecimento->save();
        $passwordReset->delete();
        $user_estabelecimento->notify(new PasswordResetSuccess($passwordReset));

        return response()->json($user_estabelecimento);
    }
}
