<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilaRequest;
use App\Models\Fila;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FilaController extends Controller
{
    public function listar()
    {
        
    }

    public function buscarId(int $id)
    {
        
    }

    public function criar(FilaRequest $request)
    {
       
    }


    public function deletar(int $id)
    {
       $fila = Fila::find($id);
       $fila -> delete($id);

       return ['message' => 'fila deletada'];
    }

    public function destroy(int $id)
    {
       
    }

    public function restore(int $id)
    {
        
    }
}
