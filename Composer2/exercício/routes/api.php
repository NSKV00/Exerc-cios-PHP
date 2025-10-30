<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\IngressoController;
use App\Http\Controllers\VendasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    //return json_encode(['massage' => 'API laravel']);
    return ['massage' => 'API laravel'];
});

// Route::get('/eventos', [EventoController::class, 'listar']);
// Route::post('/eventos', [EventoController::class, 'postar']);
// Route::delete('/eventos/{id}', [EventoController::class, 'deletar']);

Route::prefix('evento') -> group(function (){
    Route::get('', [EventoController::class, 'listar']);
    Route::get('filtrar', [EventoController::class, 'filtrar']);
    Route::get('{id}', [EventoController::class, 'buscar']);
    Route::put('{id}', [EventoController::class, 'editar']);
    Route::post('', [EventoController::class, 'postar']);
    Route::delete('{id}', [EventoController::class, 'deletar']);
});

Route::prefix('ingresso') -> group(function (){
    Route::get('{id}', [IngressoController::class, 'buscar']);
    Route::get('buscar/{id}', [IngressoController::class, 'buscarId']);
    Route::post('{id}', [IngressoController::class, 'postar']);
    Route::put('{id}', [IngressoController::class, 'editar']);
    Route::delete('{id}', [IngressoController::class, 'deletar']);
});

Route::prefix('vendas') -> group(function (){
    Route::post('', [VendasController::class, 'postar']);
});