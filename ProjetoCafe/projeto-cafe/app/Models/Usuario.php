<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model
{
    use SoftDeletes;

    protected $table = 'usuario';
    protected $primaryKey = 'id';
    protected $fillable = ['nome', 'email', 'senha', 'acesso'];
    protected $hidden = ['senha'];
    public $timestamps = true;

    public function Fila(): HasMany
    {
        return $this->hasMany(Fila::class, 'usuario_id');
    }

    public function Compras(): HasMany
    {
        return $this->hasMany(Compra::class, 'usuario_id');
    }
}
