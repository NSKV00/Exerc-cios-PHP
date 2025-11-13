<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compra extends Model
{
    use SoftDeletes;

    protected $table = 'compra';
    protected $primaryKey = 'id';
    protected $fillable = ['usuario_id', 'fila_id'];

    public function Usuario(): BelongsTo
    {
        return $this -> belongsTo(Usuario::class, 'usuario_id');
    }

    public function Fila(): BelongsTo
    {
        return $this -> belongsTo(Fila::class, 'fila_id');
    }
}
