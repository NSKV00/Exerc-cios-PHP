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
        $fila = Fila::with('Usuario')
            ->whereNull('deleted_at')
            ->orderBy('posicao', 'asc')
            ->get();

        return ['message' => 'Listando fila de usuários', 'fila' => $fila->toArray()];
    }

    public function buscarId(int $id)
    {
        $fila = Fila::with('Usuario')->findOrFail($id);
        return ['message' => "Buscando usuário na fila, ID: $id", 'fila' => $fila->toArray()];
    }

    public function criar(FilaRequest $request, int $id)
    {
        $usuario = Usuario::findOrFail($id);

        // Verifica se já está na fila
        $existente = Fila::where('usuario_id', $id)
            ->whereNull('deleted_at')
            ->first();

        if ($existente) {
            return ['message' => 'Usuário já está na fila', 'fila' => $existente->toArray()];
        }

        // Calcula próxima posição
        $ultimaFila = Fila::whereNull('deleted_at')
            ->orderBy('posicao', 'desc')
            ->first();
        
        $novaPosicao = $ultimaFila ? $ultimaFila->posicao + 1 : 1;

        $fila = new Fila();
        $fila->usuario_id = $id;
        $fila->posicao = $novaPosicao;
        $fila->save();

        return ['message' => 'Usuário adicionado à fila com sucesso', 'fila' => $fila->toArray()];
    }

    public function deletar(int $id)
    {
        $fila = Fila::findOrFail($id);
        $posicao = $fila->posicao;
        
        $fila->delete();
        
        // Reorganiza as posições
        Fila::whereNull('deleted_at')
            ->where('posicao', '>', $posicao)
            ->decrement('posicao');

        return ['message' => 'Usuário removido (soft delete) da fila'];
    }

    public function destroy(int $id)
    {
        $fila = Fila::withTrashed()->findOrFail($id);
        $fila->forceDelete();

        return ['message' => 'Usuário removido permanentemente da fila'];
    }

    public function restore(int $id)
    {
        $fila = Fila::withTrashed()->findOrFail($id);
        $fila->restore();
        $this->reorganizarFila();

        return ['message' => 'Usuário restaurado à fila com sucesso'];
    }

    public function moverAposCompra(int $usuarioId)
    {
        $filaAtual = Fila::where('usuario_id', $usuarioId)
            ->whereNull('deleted_at')
            ->first();

        if (!$filaAtual) {
            return ['message' => 'Usuário não encontrado na fila'];
        }

        $posicaoAtual = $filaAtual->posicao;
        $filaAtual->delete();

        // Reorganiza posições restantes
        Fila::whereNull('deleted_at')
            ->where('posicao', '>', $posicaoAtual)
            ->decrement('posicao');

        // Adiciona ao final
        $ultimaFila = Fila::whereNull('deleted_at')
            ->orderBy('posicao', 'desc')
            ->first();
        
        $novaPosicao = $ultimaFila ? $ultimaFila->posicao + 1 : 1;

        $novaFila = new Fila();
        $novaFila->usuario_id = $usuarioId;
        $novaFila->posicao = $novaPosicao;
        $novaFila->save();

        return ['message' => 'Usuário movido para o final da fila após compra', 'fila' => $novaFila->toArray()];
    }

    private function reorganizarFila()
    {
        $ativos = Fila::whereNull('deleted_at')
            ->orderBy('posicao', 'asc')
            ->get();

        $pos = 1;
        foreach ($ativos as $item) {
            $item->posicao = $pos;
            $item->save();
            $pos++;
        }
    }
}
