<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Validation\Rule;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function listar(Request $request)
    {
        $filtro = $request -> get('filtro');
        $consulta = Evento::query();

        if(!empty($filtro)){
            $consulta -> where('nome', 'Like', '%' . $filtro . '%');
        }

        //$evento = $filtro ? Evento::where('nome', 'like', "%$filtro%") : Evento::query();

        //dd($consulta->toRawSql());
        

        //$consulta = Evento::query();

        $eventos = $consulta -> get();

        //dd($eventos);


        return ['message' => 'Listando eventos', 'eventos' => $eventos->toArray()];
    }

    public function buscar(string $id)
    {
        $evento = Evento::findOrFail($id);


        //$consulta = Evento::query();
        //$consulta -> where('id', $id); // id = 1
        // $consulta -> where('id', '>', $id); // id > 1
        // $evento = $consulta -> get() -> first();

        //dd($evento);
        //dd($consulta->toSql());

        return ['message' => 'Buscando evento ' . $id, 'evento' => $evento->toArray()];
    }

    public function postar(Request $request)
    {
        $validate = $request -> validate([
            'nome' => ['required', 'min:5', 'string', 'max:255'],
            'data_inicio' => [
                'required',
                Rule::date() -> format('Y-m-d H:i:s')
            ],
            'data_fim' => [
                'required',
                Rule::date() -> format('Y-m-d H:i:s'),
                'after:data_inicio'
            ],
        ]);

        $evento = new Evento;
        $evento -> nome = $validate['nome'];
        $evento -> data_inicio = $validate['data_inicio'];
        $evento -> data_fim = $validate['data_fim'];
        $evento -> save();

        // $validate = $request -> validate([
        //     'nome' => 'required|min:5|string|max:255',
        //     'data_inicio' => 'required|date|date_format:Y-m-d H:i:s',
        //     'data_fim' => 'required|date|after_or_equal:data_inicio|date_format:Y-m-d H:i:s',
        // ]);
        
        //dd($validate);
        //dd($request -> input('nome'));
        return ['massage' => 'Postando eventos', 'evento' => $evento];
    }

    public function deletar(string $id)
    {
        return ['massage' => 'Deletando eventos ' . $id];
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
