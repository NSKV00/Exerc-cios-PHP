<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendas extends Model
{
    protected $table = 'vendas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function ingressos(): BelongsTo
    {
        return $this -> belongsTo(Ingressos::class);
    }

    public function eventos(): BelongsTo
    {
        return $this -> belongsTo(Evento::class);
    }
   
}
