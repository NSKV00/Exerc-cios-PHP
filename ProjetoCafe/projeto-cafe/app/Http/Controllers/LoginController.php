<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Usuario;
use App\Models\LogUsuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $logValidare = $request -> validate();

        
    }

    // public function login(LoginRequest $request)
    // {
    //     $validate = $request->validated();

    //     $usuario = Usuario::where('email', $validate['email'])
    //         ->whereNull('deleted_at')
    //         ->first();

    //     if (!$usuario || !Hash::check($validate['senha'], $usuario->senha)) {
    //         return response()->json([
    //             'message' => 'Email ou senha incorretos',
    //             'success' => false
    //         ], 401);
    //     }

    //     // Registra o acesso no log_usuario
    //     LogUsuario::create([
    //         'usuario_id' => $usuario->id,
    //         'data_acesso' => now(),
    //     ]);

    //     // Cria token com Sanctum
    //     $token = $usuario->createToken('api_token')->plainTextToken;

    //     return response()->json([
    //         'message' => 'Login realizado com sucesso',
    //         'success' => true,
    //         'usuario' => [
    //             'id' => $usuario->id,
    //             'nome' => $usuario->nome,
    //             'email' => $usuario->email,
    //             'acesso' => $usuario->acesso,
    //         ],
    //         'token' => $token,
    //     ], 200);
    // }

    // public function logout(Request $request)
    // {
    //     // Revoga todos os tokens do usuário autenticado
    //     $request->user()->tokens()->delete();

    //     return response()->json([
    //         'message' => 'Logout realizado com sucesso',
    //         'success' => true
    //     ], 200);
    // }

    // public function verificarToken(Request $request)
    // {
    //     $usuario = $request->user();

    //     if (!$usuario) {
    //         return response()->json([
    //             'message' => 'Não autenticado',
    //             'success' => false
    //         ], 401);
    //     }

    //     return response()->json([
    //         'message' => 'Autenticado',
    //         'success' => true,
    //         'usuario' => [
    //             'id' => $usuario->id,
    //             'nome' => $usuario->nome,
    //             'email' => $usuario->email,
    //             'acesso' => $usuario->acesso,
    //         ],
    //     ], 200);
    // }

    // public function historicoAcessos(int $usuarioId)
    // {
    //     $usuario = Usuario::findOrFail($usuarioId);
        
    //     $logs = LogUsuario::where('usuario_id', $usuarioId)
    //         ->whereNull('deleted_at')
    //         ->orderBy('data_acesso', 'desc')
    //         ->get();

    //     return [
    //         'message' => "Histórico de acessos do usuário: {$usuario->nome}",
    //         'usuario' => $usuario->nome,
    //         'logs' => $logs->toArray(),
    //     ];
    // }
}
