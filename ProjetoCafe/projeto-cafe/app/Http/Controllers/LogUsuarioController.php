<?php

namespace App\Http\Controllers;

use App\Models\LogUsuario;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class LogUsuarioController extends Controller
{
    public function listarTodos()
    {
        $logs = LogUsuario::with('Usuario')
            ->orderBy('data_evento', 'desc')
            ->get();

        return ResponseService::success('Listando todos os logs de usuários', $logs);
    }

    public function listarPorUsuario(int $usuarioId)
    {
        $logs = LogUsuario::where('usuario_id', $usuarioId)
            ->orderBy('data_evento', 'desc')
            ->get();

        if ($logs->isEmpty()) {
            return ResponseService::error('Nenhum log encontrado para este usuário', null, 404);
        }

        return ResponseService::success('Listando logs do usuário', $logs);
    }

    public function filtrar(Request $request)
    {
        $usuarioId = $request->query('usuario_id');
        $tipoEvento = $request->query('tipo_evento'); // 'login' ou 'logout'
        $dataInicio = $request->query('data_inicio');
        $dataFim = $request->query('data_fim');

        $query = LogUsuario::with('Usuario');

        if ($usuarioId) {
            $query->where('usuario_id', $usuarioId);
        }

        if ($tipoEvento && in_array($tipoEvento, ['login', 'logout'])) {
            $query->where('tipo_evento', $tipoEvento);
        }

        if ($dataInicio) {
            $query->whereDate('data_evento', '>=', $dataInicio);
        }

        if ($dataFim) {
            $query->whereDate('data_evento', '<=', $dataFim);
        }

        $logs = $query->orderBy('data_evento', 'desc')->get();

        if ($logs->isEmpty()) {
            return ResponseService::error('Nenhum log encontrado com os filtros especificados', null, 404);
        }

        return ResponseService::success('Listando logs filtrados', $logs);
    }

    public function relatorioPorPeriodo(Request $request)
    {
        $dataInicio = $request->query('data_inicio');
        $dataFim = $request->query('data_fim');

        if (!$dataInicio || !$dataFim) {
            return ResponseService::error('data_inicio e data_fim são obrigatórios', null, 400);
        }

        $logs = LogUsuario::with('Usuario')
            ->whereBetween('data_evento', [$dataInicio, $dataFim])
            ->orderBy('data_evento', 'desc')
            ->get();

        $resumo = [
            'total_logins' => $logs->where('tipo_evento', 'login')->count(),
            'total_logouts' => $logs->where('tipo_evento', 'logout')->count(),
            'usuarios_unicos' => $logs->pluck('usuario_id')->unique()->count(),
            'periodo' => [
                'inicio' => $dataInicio,
                'fim' => $dataFim,
            ],
        ];

        return ResponseService::success('Relatório de período', [
            'resumo' => $resumo,
            'logs' => $logs,
        ]);
    }

    public function usuariosMaisAtivos(Request $request)
    {
        $limite = $request->query('limite', 10);
        $dias = $request->query('dias', 30);

        $dataInicio = now()->subDays($dias);

        $usuarios = LogUsuario::with('Usuario')
            ->where('data_evento', '>=', $dataInicio)
            ->groupBy('usuario_id')
            ->selectRaw('usuario_id, COUNT(*) as total_eventos')
            ->orderByDesc('total_eventos')
            ->limit($limite)
            ->get();

        return ResponseService::success("Top $limite usuários mais ativos nos últimos $dias dias", $usuarios);
    }

    public function ultimoLoginDoUsuario(int $usuarioId)
    {
        $ultimoLogin = LogUsuario::where('usuario_id', $usuarioId)
            ->where('tipo_evento', 'login')
            ->orderBy('data_evento', 'desc')
            ->first();

        if (!$ultimoLogin) {
            return ResponseService::error('Nenhum login registrado para este usuário', null, 404);
        }

        return ResponseService::success('Último login do usuário', $ultimoLogin);
    }

    public function usuariosOnline()
    {
        $usuariosOnline = LogUsuario::whereNull('deleted_at')
            ->with('Usuario')
            ->groupBy('usuario_id')
            ->havingRaw('MAX(data_evento) = (SELECT MAX(data_evento) FROM log_usuario WHERE tipo_evento = "login")')
            ->where('tipo_evento', 'login')
            ->orderBy('data_evento', 'desc')
            ->get();

        return ResponseService::success('Usuários online', $usuariosOnline);
    }
}
