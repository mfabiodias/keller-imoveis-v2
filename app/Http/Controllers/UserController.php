<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(UserLoginRequest $request)
    {
        $user = User::where('email', $request->username)
            ->orWhere('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credenciais informadas estão incorretas'], 401);
        } 

        return response()->json([
            'message' => 'Token gerado com sucesso.',
            'token'   => $this->createToken($user),
            'user'    => new UserResource($user),
        ], 201);
    }

    public function logout(Request $request)
    {
        if($this->revokeToken($request->user())) {
            return response()->json(['message' => 'Usuário deslogado com sucesso.'], 202);
        } else {
            return response()->json(['message' => 'Falha ao excluir token do '.$this->context], 401);
        }
    }
    
    public function ping()
    {
        return response()->json(['message' => 'ok'], 200);
    }

    public function revokeToken($user)
    {
        return $user->tokens()->delete();
    }

    private function createToken($user)
    {
        $this->revokeToken($user);
        return $user->createToken('wapp_token')->plainTextToken;
    }
}
