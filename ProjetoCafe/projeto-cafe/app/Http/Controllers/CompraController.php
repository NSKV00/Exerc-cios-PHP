<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompraRequest;
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
        $compras = Compra::with(['Usuario', 'Fila'])
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
        $compra = Compra::with(['Usuario', 'Fila'])->findOrFail($id);

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
    public function criar(CompraRequest $request)
    {
        $validate = $request->validated();

        $usuarioId = $validate['usuario_id'];

        // Verifica se usuário está na fila
        $fila = Fila::where('usuario_id', $usuarioId)
            ->whereNull('deleted_at')
            ->orderBy('posicao', 'asc')
            ->first();

        if (!$fila) {
            return ['message' => 'Usuário não está ativo na fila.'];
        }

        // Cria a compra
        $compra = new Compra();
        $compra->usuario_id = $usuarioId;
        $compra->fila_id = $fila->id;
        $compra->cafe_qnd = $validate['cafe_qnd'];
        $compra->filtro_qnd = $validate['filtro_qnd'];
        $compra->save();

        // Move para o final da fila
        app(FilaController::class)->moverAposCompra($usuarioId);

        return [
            'message' => 'Compra registrada com sucesso e fila atualizada.',
            'compra' => $compra->toArray()
        ];
    }

    /**
     * Atualizar dados da compra
     */
    public function atualizar(Request $request, int $id)
    {
        $compra = Compra::findOrFail($id);

        $validate = $request->validate([
            'cafe_qnd' => ['sometimes', 'integer', 'min:1'],
            'filtro_qnd' => ['sometimes', 'integer', 'min:0']
        ]);

        $compra->update($validate);

        return [
            'message' => 'Compra atualizada com sucesso',
            'compra' => $compra->toArray()
        ];
    }

    /**
     * SoftDelete de uma compra
     */
    public function deletar(int $id)
    {
        $compra = Compra::findOrFail($id);
        $compra->delete();

        return ['message' => 'Compra removida (soft delete) com sucesso'];
    }

    /**
     * Exclusão permanente
     */
    public function destroy(int $id)
    {
        $compra = Compra::withTrashed()->findOrFail($id);
        $compra->forceDelete();

        return ['message' => 'Compra removida permanentemente'];
    }

    /**
     * Restaurar compra deletada
     */
    public function restore(int $id)
    {
        $compra = Compra::withTrashed()->findOrFail($id);
        $compra->restore();

        return [
            'message' => 'Compra restaurada com sucesso',
            'compra' => $compra->toArray()
        ];
    }
}
