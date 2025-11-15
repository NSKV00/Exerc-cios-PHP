<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilaRequest;
use App\Models\Fila;
use App\Models\Usuario;
use Illuminate\Http\Request;

class FilaController extends Controller
{
    public function listar()
    {
        $fila = Fila::all();
            with('usuario');

        $this -> reorganizarFila();

        return ['message' => 'Listando fila de usuários', 'fila' => $fila -> toArray()];
    }

    public function buscarId(int $id)
    {
        $fila = Usuario::with('fila')->find($id);
        if (!$fila) {
            return ['message' => "Usuário não encontrado na fila"];
        }

        $this -> reorganizarFila();

        return ['message' => "Buscando Usuário na fila, ID: $id", 'fila' => $fila->toArray()];
    }

    public function criar(FilaRequest $request, int $id)
    {
        $filaR = $request -> all();
        $filaU = Usuario::find($id);
            if (!$filaU) {
                return ['message' => 'Usuário não encontrado'];
            }

        $Ufila = Fila::orderBy('posicao', 'desc') -> first();
        $Nfila = $Ufila ? $Ufila -> posicao + 1 : 1;

        $fila = new Fila();
        $fila -> usuario_id = $filaR['usuario_id'];
        $fila ->  posicao = $Nfila;
        $fila -> save();

        return ['message' => 'Usuário adicionado à fila com sucesso', 'fila' => $fila -> toArray()];
    }

    public function deletar(int $id)
    {
        $fila = Usuario::find($id) -> where('id', $id) -> first();

        if (!$fila) {
            return ['message' => 'Usuário não encontrado na fila'];
        }

        $fila->delete($id);
        $this -> reorganizarFila();

        return ['message' => 'Usuário removido (soft delete) da fila'];
    }

    public function destroy(int $id)
    {
        $fila = Fila::withTrashed()->find($id);

        if (!$fila) {
            return ['message' => 'Usuário não encontrado (mesmo entre os deletados)'];
        }

        $fila->forceDelete();

        return ['message' => 'Usuário removido permanentemente da fila'];
    }

    public function restore(int $id)
    {
        $fila = Fila::withTrashed()->find($id);

        if (!$fila) {
            return ['message' => 'Registro não encontrado para restauração'];
        }

        $fila->restore($id);

        return ['message' => 'Usuário restaurado à fila com sucesso'];
    }

    /**
     * Função auxiliar: reorganizar a fila após uma compra
     * - O usuário atual (posição 1) é soft deleted.
     * - Ele é recolocado no fim da fila.
     */
    public function moverAposCompra(int $usuarioId)
    {
        $fila = Fila::where('usuario_id', $usuarioId)
            ->whereNull('deleted_at')
            ->orderBy('posicao', 'asc')
            ->first();

        if (!$fila) {
            return ['message' => 'Usuário não encontrado ou já removido da fila'];
        }

        // SoftDelete do usuário atual
        $fila->delete();

        // Reorganiza posições restantes (todos com posição maior)
        Fila::whereNull('deleted_at')
            ->where('posicao', '>', $fila->posicao)
            ->decrement('posicao');

        // Novo item no final da fila
        $ultimo = Fila::orderBy('posicao', 'desc')->first();
        $novaPosicao = $ultimo ? $ultimo->posicao + 1 : 1;

        $novaFila = Fila::create([
            'usuario_id' => $usuarioId,
            'posicao' => $novaPosicao
        ]);

        return [
            'message' => 'Usuário movido para o final da fila após compra',
            'fila' => $novaFila->toArray()
        ];
    }

    private function reorganizarFila()
{
    // Pega somente os usuários ativos, ordenados pela posição atual
    $ativos = Fila::whereNull('deleted_at')
        ->orderBy('posicao', 'asc')
        ->get();

    $pos = 1;

    foreach ($ativos as $item) {
        $item->posicao = $pos;
        $item->save();
        $pos++;
    }
}
}


// <?php

// namespace App\Http\Controllers;

// use App\Http\Requests\FilaRequest;
// use App\Models\Fila;
// use App\Models\Usuario;
// use Illuminate\Http\Request;

// class FilaController extends Controller
// {
//     /**
//      * Reorganiza a fila:
//      * - Remove gaps nas posições
//      * - Reordena 1,2,3...
//      */
//     private function reorganizarFila()
//     {
//         // Pega apenas registros ativos
//         $ativos = Fila::whereNull('deleted_at')
//             ->orderBy('posicao', 'asc')
//             ->get();

//         $pos = 1;

//         foreach ($ativos as $item) {
//             if ($item->posicao !== $pos) {
//                 $item->posicao = $pos;
//                 $item->save();
//             }
//             $pos++;
//         }
//     }

//     /**
//      * GET — lista a fila já organizada
//      */
//     public function listar()
//     {
//         // Garante que a fila nunca volte desorganizada
//         $this->reorganizarFila();

//         $fila = Fila::whereNull('deleted_at')
//             ->orderBy('posicao', 'asc')
//             ->with('usuario')
//             ->get();

//         return [
//             'message' => 'Listando fila de usuários',
//             'fila' => $fila->toArray()
//         ];
//     }

//     /**
//      * GET/id — traz informações do usuário + posição na fila
//      */
//     public function buscarId(int $id)
//     {
//         $fila = Usuario::with(['fila' => function ($q) {
//             $q->whereNull('deleted_at');
//         }])->find($id);

//         if (!$fila || !$fila->fila) {
//             return ['message' => "Usuário não está na fila"];
//         }

//         return [
//             'message' => "Buscando Usuário na fila, ID: $id",
//             'fila' => $fila->fila->toArray()
//         ];
//     }

//     /**
//      * Cria um novo registro na última posição da fila
//      */
//     public function criar(FilaRequest $request, int $id)
//     {
//         $dados = $request->all();

//         $usuario = Usuario::find($id);
//         if (!$usuario) {
//             return ['message' => 'Usuário não encontrado'];
//         }

//         // Última posição
//         $ultimo = Fila::whereNull('deleted_at')
//             ->orderBy('posicao', 'desc')
//             ->first();

//         $novaPosicao = $ultimo ? $ultimo->posicao + 1 : 1;

//         $fila = Fila::create([
//             'usuario_id' => $dados['usuario_id'],
//             'posicao' => $novaPosicao
//         ]);

//         return [
//             'message' => 'Usuário adicionado à fila com sucesso',
//             'fila' => $fila->toArray()
//         ];
//     }

//     /**
//      * Soft delete manual — reorganiza automaticamente
//      */
//     public function deletar(int $id)
//     {
//         $fila = Fila::where('id', $id)->first();

//         if (!$fila) {
//             return ['message' => 'Registro não encontrado na fila'];
//         }

//         $fila->delete(); // soft delete
//         $this->reorganizarFila(); // reorganiza a fila após apagar

//         return ['message' => 'Usuário removido (soft delete) da fila'];
//     }

//     /**
//      * Delete definitivo
//      */
//     public function destroy(int $id)
//     {
//         $fila = Fila::withTrashed()->find($id);

//         if (!$fila) {
//             return ['message' => 'Registro não encontrado nem entre deletados'];
//         }

//         $fila->forceDelete();

//         return ['message' => 'Usuário removido permanentemente da fila'];
//     }

//     /**
//      * Restore — reorganiza após restaurar
//      */
//     public function restore(int $id)
//     {
//         $fila = Fila::withTrashed()->find($id);

//         if (!$fila) {
//             return ['message' => 'Registro não encontrado'];
//         }

//         $fila->restore();

//         // volta reorganizado para o final
//         $ultimo = Fila::whereNull('deleted_at')
//             ->orderBy('posicao', 'desc')
//             ->first();

//         $fila->posicao = $ultimo ? $ultimo->posicao + 1 : 1;
//         $fila->save();

//         $this->reorganizarFila();

//         return ['message' => 'Usuário restaurado à fila com sucesso'];
//     }

//     /**
//      * Lógica completa: após compra
//      */
//     public function moverAposCompra(int $usuarioId)
//     {
//         $fila = Fila::where('usuario_id', $usuarioId)
//             ->whereNull('deleted_at')
//             ->orderBy('posicao', 'asc')
//             ->first();

//         if (!$fila) {
//             return ['message' => 'Usuário não encontrado ou já removido'];
//         }

//         // Remove o atual (soft delete)
//         $fila->delete();

//         // Decrementa os demais
//         Fila::whereNull('deleted_at')
//             ->where('posicao', '>', $fila->posicao)
//             ->decrement('posicao');

//         // Envia para o final
//         $ultimo = Fila::whereNull('deleted_at')
//             ->orderBy('posicao', 'desc')
//             ->first();

//         $novaPosicao = $ultimo ? $ultimo->posicao + 1 : 1;

//         $novaFila = Fila::create([
//             'usuario_id' => $usuarioId,
//             'posicao' => $novaPosicao
//         ]);

//         return [
//             'message' => 'Usuário movido para o final da fila após compra',
//             'fila' => $novaFila->toArray()
//         ];
//     }
// }
