<?php

namespace App\Models;

use App\Traits\SerializesDatetime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fila extends Model
{
    use SoftDeletes, SerializesDatetime;

    protected $table = 'fila_compra';
    protected $primaryKey = 'id';
    protected $fillable = ['usuario_id', 'posicao'];
    public $timestamps = true;

    public function Usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function Compras(): HasMany
    {
        return $this->hasMany(Compra::class, 'fila_id');
    }
}
