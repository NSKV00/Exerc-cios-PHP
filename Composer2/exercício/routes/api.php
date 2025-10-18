<?php

use App\Http\Controllers\EventoController;
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
    Route::post('', [EventoController::class, 'postar']);
    Route::delete('{id}', [EventoController::class, 'deletar']);
});