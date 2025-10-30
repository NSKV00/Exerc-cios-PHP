<?php

namespace App\Http\Controllers;

use App\Models\Vendas;
use Illuminate\Http\Request;
use App\Http\Requests\VendaRequest;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Validation\Rule;

class VendasController extends Controller
{
    public function postar(VendaRequest $request)
    {
       $validate = $request -> all();

        $vendas = new Vendas();
        $vendas -> ingresso_id = $validate['ingresso_id'];
        $vendas -> valor = $validate['valor'];
        $vendas -> documento = $validate['documento'];
        $vendas -> evento_id = $validate['evento_id'];
        $vendas -> save();

        return ['message' => 'Venda realizada com sucesso', 'venda' => $vendas];
    }

    // public function messages()
    // {
    //     return[
    //         //Mensagens de erro personalizadas
    //     ];
    // }
}
