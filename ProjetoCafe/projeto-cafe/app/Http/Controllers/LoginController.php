<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Usuario;
use App\Models\LogUsuario;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $logValidate = $request->validated();

        $usuario = Usuario::where('email', $logValidate['email'])
            ->whereNull('deleted_at')
            ->first();
            
        if (!$usuario || !Hash::check($logValidate['senha'], $usuario->senha)) {
            return ResponseService::error('Email ou senha incorretos', [], 401);
        }

        LogUsuario::create([
            'usuario_id' => $usuario->id,
            'data_acesso' => now(),
        ]);

        $token = $usuario->createToken('auth_token')->plainTextToken;

        return ResponseService::success('Login realizado com sucesso', [
            'usuario' => [
                'id' => $usuario->id,
                'nome' => $usuario->nome,
                'email' => $usuario->email,
                'acesso' => $usuario->acesso,
            ],
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        
        return ResponseService::success('Logout realizado com sucesso', null, 200);
    }

    public function verificarToken(Request $request)
    {
        $usuario = $request->user();

        if (!$usuario) {
            return ResponseService::error('Não autenticado', [], 401);
        }

        return ResponseService::success('Autenticado', [
            'usuario' => [
                'id' => $usuario->id,
                'nome' => $usuario->nome,
                'email' => $usuario->email,
                'acesso' => $usuario->acesso,
            ]
        ]);
    }
}