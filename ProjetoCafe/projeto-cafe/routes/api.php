<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    //return json_encode(['massage' => 'API laravel']);
    return ['massage' => 'API laravel'];
});

Route::prefix('usuario') -> group(function (){
    Route::get('/', [UsuarioController::class, 'listar']);
    Route::get('/{id}', [UsuarioController::class, 'buscarId']);
    Route::post('/criar', [UsuarioController::class, 'criar']);
    Route::put('/atualizar/{id}', [UsuarioController::class, 'atualizar']);
    Route::delete('/deletar/{id}', [UsuarioController::class, 'deletar']);
    Route::delete('/destroy/{id}', [UsuarioController::class, 'destroy']);
    Route::post('/restore/{id}', [UsuarioController::class, 'restore']);
});