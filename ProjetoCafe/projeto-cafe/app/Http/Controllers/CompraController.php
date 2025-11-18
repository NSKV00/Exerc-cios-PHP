<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompraRequest;
use App\Models\Compra;
use App\Models\Fila;
use App\Models\Usuario;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function listar()
    {
        $compras = Compra::with(['usuario', 'fila'])
            -> orderBy('created_at', 'desc')
            -> get();

        return ['message' => 'Listando todas as compras', 'compras' => $compras->toArray()];
    }

    public function buscarId(int $id)
    {
        $compra = Compra::with(['usuario', 'fila']) -> findOrFail($id);

        return ['message' => "Compra encontrada ID: $id", 'compra' => $compra -> toArray()];
    }

    public function criar(CompraRequest $request)
    {
        $validate = $request -> validated();

        $usuarioId = $validate['usuario_id'];

        $fila = Fila::where('usuario_id', $usuarioId)
            -> whereNull('deleted_at')
            -> orderBy('posicao', 'asc')
            -> first();

        if (!$fila) {
            return ['message' => 'Usuário não está ativo na fila.'];
        }

        $compra = new Compra();
        $compra -> usuario_id = $usuarioId;
        $compra -> fila_id = $fila->id;
        $compra -> cafe_qnd = $validate['cafe_qnd'];
        $compra -> filtro_qnd = $validate['filtro_qnd'];
        $compra -> save();

        app(FilaController::class) -> moverAposCompra($usuarioId);

        return ['message' => 'Compra registrada com sucesso e fila atualizada.','compra' => $compra -> toArray()];
    }

    public function atualizar(Request $request, int $id)
    {
        $compra = Compra::findOrFail($id);

        $validate = $request->validate([
            'cafe_qnd' => ['sometimes', 'integer', 'min:1'],
            'filtro_qnd' => ['sometimes', 'integer', 'min:0']
        ]);

        $compra -> update($validate);

        return [
            'message' => 'Compra atualizada com sucesso',
            'compra' => $compra -> toArray()
        ];
    }

    public function deletar(int $id)
    {
        $compra = Compra::findOrFail($id);
        $usuarioId = $compra->usuario_id;
        $filaId = $compra->fila_id;
        
        // Soft delete da compra
        $compra -> delete();
        
        // Restaura o usuário à fila anterior
        $this->restaurarUsuarioNaFila($usuarioId, $filaId);

        return ['message' => 'Compra removida (soft delete) com sucesso'];
    }

    public function destroy(int $id)
    {
        $compra = Compra::withTrashed() -> findOrFail($id);
        $usuarioId = $compra->usuario_id;
        $filaId = $compra->fila_id;
        
        // Force delete da compra
        $compra -> forceDelete();
        
        // Restaura o usuário à fila anterior
        $this->restaurarUsuarioNaFila($usuarioId, $filaId);

        return ['message' => 'Compra removida permanentemente'];
    }

    public function restore(int $id)
    {
        $compra = Compra::withTrashed() -> findOrFail($id);
        $compra -> restore();

        return ['message' => 'Compra restaurada com sucesso', 'compra' => $compra -> toArray()];
    }

    private function restaurarUsuarioNaFila(int $usuarioId, int $filaId)
    {
        // Busca a fila anterior do usuário
        $filaAnterior = Fila::withTrashed()->findOrFail($filaId);
        
        // Busca a fila atual do usuário (após a compra)
        $filaAtual = Fila::where('usuario_id', $usuarioId)
            ->whereNull('deleted_at')
            ->first();

        if (!$filaAtual || $filaAtual->id === $filaAnterior->id) {
            return;
        }

        // Posição anterior
        $posicaoAnterior = $filaAnterior->posicao;
        $posicaoAtual = $filaAtual->posicao;

        // Remove usuário da posição atual
        $filaAtual->delete();

        // Reorganiza as posições depois da posição atual
        Fila::whereNull('deleted_at')
            ->where('posicao', '>', $posicaoAtual)
            ->decrement('posicao');

        // Restaura usuário na posição anterior
        $filaAnterior->restore();
        
        // Reorganiza as posições após a posição anterior inserida
        Fila::whereNull('deleted_at')
            ->where('posicao', '>=', $posicaoAnterior)
            ->where('id', '!=', $filaAnterior->id)
            ->increment('posicao');

        $filaAnterior->posicao = $posicaoAnterior;
        $filaAnterior->save();
    }
}
