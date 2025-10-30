<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ingressos extends Model
{
    protected $table = 'ingressos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function evento(): BelongsTo
    {
        return $this -> belongsTo(Evento::class);
    }
}
