<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngressoRequest;
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
            //-> with('ingressos')
            //-> withTrashed();

        $id = (int) $id;
        if (!empty($id)){
            $ingresso -> where('evento_id', $id);
        }

        $consulta = $ingresso -> get();

        return ['message' => 'Buscando ingressos ', 'eventos' => $consulta->toArray()];
    }

    public function buscarId(string $id)
    {
        $ingresso = Ingressos::findOrFail($id)
            ->with('eventos')
            ->withTrashed();

        return ['message' => 'Buscando ingresso ' . $id, 'ingresso' => $ingresso->toArray()];
    }

    public function postar(IngressoRequest $request, string $id)
    {
        $validate = $request -> all();

        $ingresso = new Ingressos;
        $ingresso -> tipo = $validate['tipo']; 
        $ingresso -> valor = $validate['valor'];
        $ingresso -> evento_id = $id;
        $ingresso -> save();

        return ['massage' => 'Postando ingresso', 'evento' => $ingresso];
    }

    public function editar(Request $request, string $id)
    {
        $validate = $request -> all();

        $ingresso = Ingressos::find($id);
        $ingresso -> tipo = $validate['tipo']; 
        $ingresso -> valor = $validate['valor'];
        $ingresso -> evento_id = $id;
        $ingresso -> save();

        return ['massage' => 'Ingresso editado'];
    }

    public function deletar(int $id)
    {
        $ingresso = Ingressos::find($id);
        $ingresso -> delete();

        return ['massage' => 'Ingresso' . $id . 'deletado'];
    }
}
