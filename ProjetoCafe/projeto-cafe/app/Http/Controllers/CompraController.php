<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompraRequest;
use App\Models\Compra;
use App\Models\Fila;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function listar()
    {
        $compras = Compra::with(['usuario', 'fila'])
            ->orderBy('created_at', 'desc')
            ->get();

        return ResponseService::success('Listando todas as compras', $compras);
    }

    public function buscarId(int $id)
    {
        $compra = Compra::with(['usuario', 'fila'])->findOrFail($id);

        return ResponseService::success("Compra encontrada ID: $id", $compra);
    }

    public function criar(CompraRequest $request)
    {
        $validate = $request->validated();
        $usuarioId = $validate['usuario_id'];

        $fila = Fila::where('usuario_id', $usuarioId)
            ->whereNull('deleted_at')
            ->orderBy('posicao', 'asc')
            ->first();

        if (!$fila) {
            return ResponseService::error('Usuário não está ativo na fila', null, 404);
        }

        $compra = new Compra();
        $compra->usuario_id = $usuarioId;
        $compra->fila_id = $fila->id;
        $compra->cafe_qnd = $validate['cafe_qnd'];
        $compra->filtro_qnd = $validate['filtro_qnd'];
        $compra->save();

        app(FilaController::class)->moverAposCompra($usuarioId);

        return ResponseService::success('Compra registrada com sucesso e fila atualizada', $compra, 201);
    }

    public function atualizar(Request $request, int $id)
    {
        $compra = Compra::findOrFail($id);

        $validate = $request->validate([
            'cafe_qnd' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'filtro_qnd' => ['sometimes', 'integer', 'min:0','max:100'],
        ], [
            'cafe_qnd.min' => 'Deve ser comprado no mínimo 1 café.',
            'cafe_qnd.max' => 'A quantidade de café não pode exceder 999 unidades.',
            'filtro_qnd.min' => 'A quantidade de filtro não pode ser negativa.',
            'filtro_qnd.max' => 'A quantidade de filtro não pode exceder 999 unidades.',
        ]);

        $compra->update($validate);

        return ResponseService::success('Compra atualizada com sucesso', $compra);
    }

    public function deletar(int $id)
    {
        $compra = Compra::findOrFail($id);
        $usuarioId = $compra->usuario_id;
        $filaId = $compra->fila_id;
        
        $compra->delete();
        
        $this->restaurarUsuarioNaFila($usuarioId, $filaId);

        return ResponseService::success('Compra removida (soft delete) com sucesso', null);
    }

    public function destroy(int $id)
    {
        $compra = Compra::withTrashed()->findOrFail($id);
        $usuarioId = $compra->usuario_id;
        $filaId = $compra->fila_id;
        
        $compra->forceDelete();
        
        $this->restaurarUsuarioNaFila($usuarioId, $filaId);

        return ResponseService::success('Compra removida permanentemente', null);
    }

    public function restore(int $id)
    {
        $compra = Compra::withTrashed()->findOrFail($id);
        $compra->restore();

        app(FilaController::class)->moverAposCompra($compra->usuario_id);

        return ResponseService::success('Compra restaurada com sucesso', $compra);
    }

    private function restaurarUsuarioNaFila(int $usuarioId, int $filaId)
    {
        $filaAnterior = Fila::withTrashed()->find($filaId);
        
        if (!$filaAnterior) {
            return;
        }
        
        $filaAtual = Fila::where('usuario_id', $usuarioId)
            ->whereNull('deleted_at')
            ->first();

        if (!$filaAtual || $filaAtual->id === $filaAnterior->id) {
            return;
        }

        $posicaoAnterior = $filaAnterior->posicao;
        $posicaoAtual = $filaAtual->posicao;

        $filaAtual->delete();

        Fila::whereNull('deleted_at')
            ->where('posicao', '>', $posicaoAtual)
            ->decrement('posicao');

        $filaAnterior->restore();
        
        Fila::whereNull('deleted_at')
            ->where('posicao', '>=', $posicaoAnterior)
            ->where('id', '!=', $filaAnterior->id)
            ->increment('posicao');

        $filaAnterior->posicao = $posicaoAnterior;
        $filaAnterior->save();
    }
}