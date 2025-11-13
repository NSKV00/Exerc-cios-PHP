<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilaRequest;
use App\Models\Fila;
use App\Models\Usuario;
use Illuminate\Http\Request;

class FilaController extends Controller
{
    public function listar()
    {
        $fila = Fila::all();
            with('usuario');

        return ['message' => 'Listando fila de usuários', 'fila' => $fila -> toArray()];
        // $fila = Fila::with('usuario')
        //     ->orderBy('posicao', 'asc')
        //     ->get();

        // return ['message' => 'Listando fila de usuários', 'fila' => $fila->toArray() ];
    }

    public function buscarId(int $id)
    {
        $fila = Fila::with('usuario')->find($id);

        if (!$fila) {
            return ['message' => "Usuário não encontrado na fila"];
        }

        return ['message' => "Buscando fila do usuário ID: $id", 'fila' => $fila->toArray()];
    }

    public function criar(FilaRequest $request, int $id)
    {
        $filaR = $request -> all();
        $filaU = Usuario::find($id);
            if (!$filaU) {
                return ['message' => 'Usuário não encontrado'];
            }

        $Ufila = Fila::orderBy('posicao', 'desc') -> first();
        $Nfila = $Ufila ? $Ufila -> posicao + 1 : 1;

        $fila = new Fila();
        $fila -> usuario_id = $filaR['usuario_id'];
        $fila ->  posicao = $Nfila;
        $fila -> save();

        return ['message' => 'Usuário adicionado à fila com sucesso', 'fila' => $fila -> toArray()];
    }

    public function deletar(int $id)
    {
        $fila = Fila::find($id);

        if (!$fila) {
            return ['message' => 'Usuário não encontrado na fila'];
        }

        $fila->delete();

        return ['message' => 'Usuário removido (soft delete) da fila'];
    }

    public function destroy(int $id)
    {
        $fila = Fila::withTrashed()->find($id);

        if (!$fila) {
            return ['message' => 'Usuário não encontrado (mesmo entre os deletados)'];
        }

        $fila->forceDelete();

        return ['message' => 'Usuário removido permanentemente da fila'];
    }

    public function restore(int $id)
    {
        $fila = Fila::withTrashed()->find($id);

        if (!$fila) {
            return ['message' => 'Registro não encontrado para restauração'];
        }

        $fila->restore();

        return ['message' => 'Usuário restaurado à fila com sucesso'];
    }

    /**
     * Função auxiliar: reorganizar a fila após uma compra
     * - O usuário atual (posição 1) é soft deleted.
     * - Ele é recolocado no fim da fila.
     */
    public function moverAposCompra(int $usuarioId)
    {
        $fila = Fila::where('usuario_id', $usuarioId)
            ->whereNull('deleted_at')
            ->orderBy('posicao', 'asc')
            ->first();

        if (!$fila) {
            return ['message' => 'Usuário não encontrado ou já removido da fila'];
        }

        // SoftDelete do usuário atual
        $fila->delete();

        // Reorganiza posições restantes (todos com posição maior)
        Fila::whereNull('deleted_at')
            ->where('posicao', '>', $fila->posicao)
            ->decrement('posicao');

        // Novo item no final da fila
        $ultimo = Fila::orderBy('posicao', 'desc')->first();
        $novaPosicao = $ultimo ? $ultimo->posicao + 1 : 1;

        $novaFila = Fila::create([
            'usuario_id' => $usuarioId,
            'posicao' => $novaPosicao
        ]);

        return [
            'message' => 'Usuário movido para o final da fila após compra',
            'fila' => $novaFila->toArray()
        ];
    }
}
