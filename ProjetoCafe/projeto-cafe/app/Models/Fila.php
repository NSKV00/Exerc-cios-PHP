<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fila extends Model
{
    use SoftDeletes;
    protected $table = 'fila_compra';
    protected $primaryKey = 'id';

    public function Compra(): HasMany
    {
        return $this -> hasMany(Compra::class);
    }

    public function Usuario(): BelongsTo
    {
        return $this -> belongsTo(Usuario::class);
    }
}
