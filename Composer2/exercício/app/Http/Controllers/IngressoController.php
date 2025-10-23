<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use App\Models\Ingressos;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Validation\Rule;

class IngressoController extends Controller
{
    public function buscar(string $id)
    {
        $ingresso = Ingressos::query();

        $id = (int) $id;
        if (!empty($id)){
            $ingresso -> where('evento_id', $id);
        }

        $consulta = $ingresso -> get();

        return ['message' => 'Buscando ingressos ', 'eventos' => $consulta->toArray()];
    }

    public function postar(Request $request, string $id)
    {
        $validate = $request -> validate([
            'tipo' => ['required', 'string'],
            'valor' => ['required', 'int', 'min:0'],
        ]);

        $ingresso = new Ingressos;
        $ingresso -> tipo = $validate['tipo']; 
        $ingresso -> valor = $validate['valor'];
        $ingresso -> evento_id = $id;
        $ingresso -> save();

        return ['massage' => 'Postando ingresso', 'evento' => $ingresso];
    }
}
