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
    protected $hidden = ['senha'];
    public $timestamps = false;

    public function Fila(): HasMany
    {
        return $this -> hasMany(Fila::class, );
    }

    public function Compra(): HasMany
    {
        return $this -> hasMany(Compra::class);
    }
}
