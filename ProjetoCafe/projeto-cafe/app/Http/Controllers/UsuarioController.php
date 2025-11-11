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
        $evento = Usuario::all();

        return ['message' => 'Listando usuários', 'usuários' => $evento -> toArray()];
    }

    public function buscarId(int $id)
    {
        $evento = Usuario::findorFail($id);

        return ['message' => 'Buscando usuário' . $id, 'usuário' => $evento -> toArray()];
    }

    public function criar(UsuarioRequest $request)
    {
        $validate = $request -> all();

        $usuario = new Usuario();
        $usuario -> nome = $validate['nome'];
        $usuario -> email = $validate['email'];
        $usuario -> senha = Hash::make($validate['senha']);
        $usuario -> save();

        return ['message' => 'Usuário criado com sucesso', 'usuário' => $usuario -> toArray()];
    }

    public function atualizar(Request $request, int $id)
    {
        $validate = $request -> validate([
            'nome' => ['required', 'string'],
            'email' => ['required', 'string', "unique:usuario,email,$id,id"],
            'acesso' => ['required', 'string', 'in:usuario,admin'],
        ]);

        $usuario = Usuario::find($id);
            if (!$usuario){
                return ['message' => 'Usuário não encontrado'];
            }
        $usuario -> nome =  $validate['nome'];
        $usuario -> email =  $validate['email'];
        $usuario->acesso = $validate['acesso'];
        $usuario -> save();

        return ['message' => 'Usuário atualizado com sucesso', 'usuário' => $usuario -> toArray()];
    }

    public function deletar(int $id)
    {
        $evento = Usuario::find($id);
        $evento -> delete($id);
        
        return ['message' => 'Usuário deletado com sucesso' . $id];
    }

    public function destroy(int $id)
    {
        $evento = Usuario::withTrashed() -> find($id);
        $evento -> forceDelete($id);

        return ['message' => 'Usuário destruido com sucesso' . $id];
    }

    public function restore(int $id)
    {
        $evento = Usuario::withTrashed($id);
        $evento -> restore($id);

        return ['message' => 'Usuário restaurado com sucesso' . $id]; 
    }
}
