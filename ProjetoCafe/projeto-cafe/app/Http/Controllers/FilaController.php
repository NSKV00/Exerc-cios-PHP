<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilaRequest;
use App\Models\Fila;
use App\Models\Usuario;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FilaController extends Controller
{
    public function listar()
    {
        $fila = Fila::with('Usuario', 'Compras')
            ->whereNull('deleted_at')
            ->orderBy('posicao', 'asc')
            ->get();

        return ResponseService::success('Listando fila de usuários', $fila);
    }

    public function buscarId(int $id)
    {
        $fila = Usuario::with('fila')->findOrFail($id);
        
        return ResponseService::success("Buscando usuário na fila, ID: $id", $fila);
    }

    public function criar(FilaRequest $request)
    {
        $fila = Usuario::findOrFail($request->usuario_id);

        $existente = Fila::where('usuario_id', $request->usuario_id)
            ->whereNull('deleted_at')
            ->first();

        if ($existente) {
            return ResponseService::error('Usuário já está na fila', null, 409);
        }

        $ultimaFila = Fila::whereNull('deleted_at')
            ->orderBy('posicao', 'desc')
            ->first();
        
        $novaPosicao = $ultimaFila ? $ultimaFila->posicao + 1 : 1;

        $fila = new Fila();
        $fila->usuario_id = $request->usuario_id;
        $fila->posicao = $novaPosicao;
        $fila->save();

        return ResponseService::success('Usuário adicionado à fila com sucesso', $fila, 201);
    }

    public function deletar(int $id)
    {
        $fila = Fila::findOrFail($id);
        $posicao = $fila->posicao;
        
        $fila->delete();
        
        Fila::whereNull('deleted_at')
            ->where('posicao', '>', $posicao)
            ->decrement('posicao');

        return ResponseService::success('Usuário removido (soft delete) da fila', null);
    }

    public function destroy(int $id)
    {
        $fila = Fila::withTrashed()->findOrFail($id);
        $fila->forceDelete();

        return ResponseService::success('Usuário removido permanentemente da fila', null);
    }

    public function restore(int $id)
    {
        $fila = Fila::withTrashed()->findOrFail($id);
        $fila->restore();
        $this->reorganizarFila();

        return ResponseService::success('Usuário restaurado à fila com sucesso', $fila);
    }

    public function moverAposCompra(int $usuarioId)
    {
        $filaAtual = Fila::where('usuario_id', $usuarioId)
            ->whereNull('deleted_at')
            ->first();

        if (!$filaAtual) {
            return null;
        }

        $posicaoAtual = $filaAtual->posicao;
        $filaAtual->delete();

        Fila::whereNull('deleted_at')
            ->where('posicao', '>', $posicaoAtual)
            ->decrement('posicao');

        $ultimaFila = Fila::whereNull('deleted_at')
            ->orderBy('posicao', 'desc')
            ->first();
        
        $novaPosicao = $ultimaFila ? $ultimaFila->posicao + 1 : 1;

        $novaFila = new Fila();
        $novaFila->usuario_id = $usuarioId;
        $novaFila->posicao = $novaPosicao;
        $novaFila->save();

        return $novaFila;
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

    public function proximo()
    {
        try {
            $fila = Fila::whereNull('deleted_at')
                ->orderBy('posicao', 'asc')
                ->first();

            if (!$fila) {
                // Retornamos success com data null para facilitar consumo no frontend
                return ResponseService::success('Fila vazia', null);
            }

            // Carrega relação com nome canônico (minúsculo) e monte um payload simples e previsível
            $fila->load('usuario');
            $usuario = $fila->usuario;

            $payload = [
                'id' => $fila->id,
                'usuario_id' => $fila->usuario_id,
                'posicao' => $fila->posicao,
                'usuario' => $usuario ? [
                    'id' => $usuario->id,
                    'nome' => $usuario->nome ?? null,
                    'email' => $usuario->email ?? null,
                ] : null,
                'created_at' => $fila->created_at,
            ];

            return ResponseService::success('Próximo na fila', $payload);
        } catch (\Throwable $e) {
            // Log completo para debug sem vazar stack para o cliente
            Log::error('Erro em FilaController::proximo', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return ResponseService::error('Erro interno ao obter próximo da fila', null, 500);
        }
    }

    public function posicaoUsuario($usuario_id)
    {
        $fila = Fila::where('usuario_id', $usuario_id)
            ->whereNull('deleted_at')
            ->first();
        
        if (!$fila) {
            return ResponseService::error('Usuário não está na fila', null, 404);
        }
        
        return ResponseService::success('Posição do usuário', [
            'posicao' => $fila->posicao,
            'usuario_id' => $usuario_id,
        ]);
    }
}
