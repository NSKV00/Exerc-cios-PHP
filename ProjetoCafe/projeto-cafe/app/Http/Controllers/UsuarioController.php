<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\Usuario;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function listar()
    {
        $usuarios = Usuario::all();
        return ResponseService::success('Listando usuários', $usuarios);
    }

    public function buscarId(int $id)
    {
        $usuario = Usuario::findOrFail($id);
        return ResponseService::success("Usuário encontrado: $id", $usuario);
    }

    public function criar(UsuarioRequest $request)
    {
        $validate = $request->validated();

        $usuario = new Usuario();
        $usuario->nome = $validate['nome'];
        $usuario->email = $validate['email'];
        $usuario->senha = Hash::make($validate['senha']);
        $usuario->acesso = $validate['acesso'] ?? 'usuario';
        $usuario->save();

        return ResponseService::success('Usuário criado com sucesso', $usuario, 201);
    }

    public function atualizar(Request $request, int $id)
    {
        $usuario = Usuario::findOrFail($id);

        $validate = $request->validate([
            'nome' => ['sometimes', 'string', 'min:3', 'max:100', 'regex:/^[\p{L}\s\'-]+$/u'],
            'email' => ['sometimes', 'email:rfc,dns', "unique:usuario,email,$id,id", 'max:100'],
            'acesso' => ['sometimes', 'string', 'in:usuario,admin'],
        ], [
            'nome.regex' => 'O nome pode conter apenas letras, espaços, hífens e apóstrofos.',
            'email.email' => 'O email deve ser um endereço válido.',
            'email.unique' => 'Este email já está registrado no sistema.',
            'acesso.in' => 'O acesso deve ser "usuario" ou "admin".',
        ]);

        $usuario->update($validate);

        return ResponseService::success('Usuário atualizado com sucesso', $usuario);
    }

    public function deletar(int $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        
        return ResponseService::success('Usuário deletado com sucesso (soft delete)', null);
    }

    public function destroy(int $id)
    {
        $usuario = Usuario::withTrashed()->findOrFail($id);
        $usuario->forceDelete();

        return ResponseService::success('Usuário destruído com sucesso', null);
    }

    public function restore(int $id)
    {
        $usuario = Usuario::withTrashed()->findOrFail($id);
        $usuario->restore();

        return ResponseService::success('Usuário restaurado com sucesso', $usuario);
    }
}
