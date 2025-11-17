<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function listar()
    {
        $usuarios = Usuario::all();
        return ['message' => 'Listando usuários', 'usuários' => $usuarios->toArray()];
    }

    public function buscarId(int $id)
    {
        $usuario = Usuario::findOrFail($id);
        return ['message' => 'Buscando usuário: ' . $id, 'usuário' => $usuario->toArray()];
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

        return ['message' => 'Usuário criado com sucesso', 'usuário' => $usuario->toArray()];
    }

    public function atualizar(Request $request, int $id)
    {
        $usuario = Usuario::findOrFail($id);

        $validate = $request->validate([
            'nome' => ['sometimes', 'string', 'min:3', 'max:100'],
            'email' => ['sometimes', 'string', 'email', "unique:usuario,email,$id,id"],
            'acesso' => ['sometimes', 'string', 'in:usuario,admin'],
        ]);

        $usuario->update($validate);

        return ['message' => 'Usuário atualizado com sucesso', 'usuário' => $usuario->toArray()];
    }

    public function deletar(int $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        
        return ['message' => 'Usuário deletado com sucesso (soft delete)'];
    }

    public function destroy(int $id)
    {
        $usuario = Usuario::withTrashed()->findOrFail($id);
        $usuario->forceDelete();

        return ['message' => 'Usuário destruído com sucesso'];
    }

    public function restore(int $id)
    {
        $usuario = Usuario::withTrashed()->findOrFail($id);
        $usuario->restore();

        return ['message' => 'Usuário restaurado com sucesso'];
    }
}
