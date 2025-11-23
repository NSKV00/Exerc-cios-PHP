<?php

namespace App\Models;

use App\Traits\SerializesDatetime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Model
{
    use SoftDeletes, HasApiTokens, SerializesDatetime;

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

    public function LogsAcesso(): HasMany
    {
        return $this->hasMany(LogUsuario::class, 'usuario_id');
    }
}
