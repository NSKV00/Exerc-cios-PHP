<?php

use App\Http\Controllers\CompraController;
use App\Http\Controllers\FilaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LogUsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('usuario') -> group(function (){
    Route::get('', [UsuarioController::class, 'listar']);
    Route::get('/{id}', [UsuarioController::class, 'buscarId']);
    Route::post('/criar', [UsuarioController::class, 'criar']);
    Route::middleware('auth:sanctum')->put('/atualizar/{id}', [UsuarioController::class, 'atualizar']);
    Route::middleware('auth:sanctum')->delete('/deletar/{id}', [UsuarioController::class, 'deletar']);
    Route::middleware(['auth:sanctum', 'admin'])->put('/atualizarAcesso/{id}', [UsuarioController::class, 'atualizarAcesso']);
    Route::middleware(['auth:sanctum', 'admin'])->delete('/destroy/{id}', [UsuarioController::class, 'destroy']);
    Route::middleware(['auth:sanctum', 'admin'])->post('/restore/{id}', [UsuarioController::class, 'restore']);
});

Route::prefix('fila') -> group(function (){
    Route::get('', [FilaController::class, 'listar']);
    Route::get('/{id}', [FilaController::class, 'buscarId']);
    Route::middleware('auth:sanctum')->post('/criar', [FilaController::class, 'criar']);
    Route::middleware('auth:sanctum')->delete('/deletar/{id}', [FilaController::class, 'deletar']);
    Route::middleware(['auth:sanctum', 'admin'])->delete('/destroy/{id}', [FilaController::class, 'destroy']);
    Route::middleware(['auth:sanctum', 'admin'])->post('/restore/{id}', [FilaController::class, 'restore']);
    Route::get('/proximo', [FilaController::class, 'proximo']);
    Route::get('/posicao/{usuario_id}', [FilaController::class, 'posicaoUsuario']);

});

Route::prefix('compra') -> group(function (){
    Route::get('', [CompraController::class, 'listar']);
    Route::get('/{id}', [CompraController::class, 'buscarId']);
    Route::middleware('auth:sanctum')->post('/criar', [CompraController::class, 'criar']);
    Route::middleware('auth:sanctum')->put('/atualizar/{id}', [CompraController::class, 'atualizar']);
    Route::middleware('auth:sanctum')->delete('/deletar/{id}', [CompraController::class, 'deletar']);
    Route::middleware(['auth:sanctum', 'admin'])->delete('/destroy/{id}', [CompraController::class, 'destroy']);
    Route::middleware(['auth:sanctum', 'admin'])->post('/restore/{id}', [CompraController::class, 'restore']);
});

Route::prefix('login') -> group(function (){
    Route::post('', [LoginController::class, 'login']);
    Route::middleware('auth:sanctum')->get('/verificarToken', [LoginController::class, 'verificarToken']);
    Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);
});

Route::prefix('logs') -> group(function (){
    Route::middleware(['auth:sanctum', 'admin'])->get('', [LogUsuarioController::class, 'listarTodos']);
    Route::middleware(['auth:sanctum', 'admin'])->get('/usuario/{usuarioId}', [LogUsuarioController::class, 'listarPorUsuario']);
    Route::middleware(['auth:sanctum', 'admin'])->get('/filtrar', [LogUsuarioController::class, 'filtrar']);
    Route::middleware(['auth:sanctum', 'admin'])->get('/relatorio/periodo', [LogUsuarioController::class, 'relatorioPorPeriodo']);
    Route::middleware(['auth:sanctum', 'admin'])->get('/usuarios/ativos', [LogUsuarioController::class, 'usuariosMaisAtivos']);
    Route::middleware(['auth:sanctum', 'admin'])->get('/usuario/{usuarioId}/ultimo-login', [LogUsuarioController::class, 'ultimoLoginDoUsuario']);
    Route::middleware(['auth:sanctum', 'admin'])->get('/usuarios/online', [LogUsuarioController::class, 'usuariosOnline']);
});