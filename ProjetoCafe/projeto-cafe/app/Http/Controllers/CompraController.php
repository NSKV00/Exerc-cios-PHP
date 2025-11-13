<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Fila;
use App\Models\Usuario;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Listar todas as compras
     */
    public function listar()
    {
        $compras = Compra::with(['usuario', 'fila'])
            ->orderBy('created_at', 'desc')
            ->get();

        return [
            'message' => 'Listando todas as compras',
            'compras' => $compras->toArray()
        ];
    }

    /**
     * Buscar compra por ID
     */
    public function buscarId(int $id)
    {
        $compra = Compra::with(['usuario', 'fila'])->find($id);

        if (!$compra) {
            return ['message' => 'Compra não encontrada'];
        }

        return [
            'message' => "Compra encontrada ID: $id",
            'compra' => $compra->toArray()
        ];
    }

    /**
     * Criar nova compra
     * - O usuário precisa estar na fila
     * - Após a compra, o usuário é movido para o fim da fila
     */
    public function criar(Request $request)
    {
        $validate = $request->validate([
            'usuario_id' => ['required', 'integer'],
            'valor' => ['required', 'numeric'],
            'descricao' => ['nullable', 'string']
        ]);

        $usuarioId = $validate['usuario_id'];

        // Verifica se o usuário está ativo na fila
        $fila = Fila::where('usuario_id', $usuarioId)
            ->whereNull('deleted_at')
            ->orderBy('posicao', 'asc')
            ->first();

        if (!$fila) {
            return ['message' => 'Usuário não está ativo na fila.'];
        }

        // Cria a compra
        $compra = Compra::create([
            'usuario_id' => $usuarioId,
            'fila_id' => $fila->id,
            'valor' => $validate['valor'],
            'descricao' => $validate['descricao'] ?? null,
        ]);

        // Move o usuário para o final da fila (SoftDelete e recriação)
        app(FilaController::class)->moverAposCompra($usuarioId);

        return [
            'message' => 'Compra registrada com sucesso e fila atualizada.',
            'compra' => $compra->toArray()
        ];
    }

    /**
     * SoftDelete de uma compra
     */
    public function deletar(int $id)
    {
        $compra = Compra::find($id);

        if (!$compra) {
            return ['message' => 'Compra não encontrada'];
        }

        $compra->delete();

        return ['message' => 'Compra removida (soft delete) com sucesso'];
    }

    /**
     * Exclusão permanente
     */
    public function destroy(int $id)
    {
        $compra = Compra::withTrashed()->find($id);

        if (!$compra) {
            return ['message' => 'Compra não encontrada (nem entre as deletadas)'];
        }

        $compra->forceDelete();

        return ['message' => 'Compra removida permanentemente'];
    }

    /**
     * Restaurar compra deletada
     */
    public function restore(int $id)
    {
        $compra = Compra::withTrashed()->find($id);

        if (!$compra) {
            return ['message' => 'Compra não encontrada para restauração'];
        }

        $compra->restore();

        return ['message' => 'Compra restaurada com sucesso'];
    }
}
