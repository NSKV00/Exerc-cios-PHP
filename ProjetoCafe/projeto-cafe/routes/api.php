<?php

use App\Http\Controllers\CompraController;
use App\Http\Controllers\FilaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return ['message' => 'API laravel'];
});

Route::prefix('login') -> group(function (){
    Route::post('/entrar', [LoginController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('login') -> group(function (){
        Route::post('/sair', [LoginController::class, 'logout']);
        Route::get('/verificar', [LoginController::class, 'verificarToken']);
        Route::get('/historico/{Id}', [LoginController::class, 'historicoAcessos']);
    });

    Route::prefix('usuario') -> group(function (){
        Route::get('', [UsuarioController::class, 'listar']);
        Route::get('/{id}', [UsuarioController::class, 'buscarId']);
        Route::post('/criar', [UsuarioController::class, 'criar']);
        Route::put('/atualizar/{id}', [UsuarioController::class, 'atualizar']);
        Route::delete('/deletar/{id}', [UsuarioController::class, 'deletar']);
        Route::delete('/destroy/{id}', [UsuarioController::class, 'destroy']);
        Route::post('/restore/{id}', [UsuarioController::class, 'restore']);
    });

    Route::prefix('fila') -> group(function (){
        Route::get('', [FilaController::class, 'listar']);
        Route::get('/{id}', [FilaController::class, 'buscarId']);
        Route::post('/criar/{id}', [FilaController::class, 'criar']);
        Route::delete('/deletar/{id}', [FilaController::class, 'deletar']);
        Route::delete('/destroy/{id}', [FilaController::class, 'destroy']);
        Route::post('/restore/{id}', [FilaController::class, 'restore']);
    });

    Route::prefix('compra') -> group(function (){
        Route::get('', [CompraController::class, 'listar']);
        Route::get('/{id}', [CompraController::class, 'buscarId']);
        Route::post('/criar', [CompraController::class, 'criar']);
        Route::put('/atualizar/{id}', [CompraController::class, 'atualizar']);
        Route::delete('/deletar/{id}', [CompraController::class, 'deletar']);
        Route::delete('/destroy/{id}', [CompraController::class, 'destroy']);
        Route::post('/restore/{id}', [CompraController::class, 'restore']);
    });
});