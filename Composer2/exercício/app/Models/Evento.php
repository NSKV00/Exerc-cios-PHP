<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    //use SoftDeletes; Ter na tabela eventos a coluna deleted_at para funcionar
    protected $table = 'eventos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function  ingressos(): HasMany
    {
       return $this -> hasMany(Ingressos::class); 
    }

    public function  vendas(): HasMany
    {
       return $this -> hasMany(Vendas::class); 
    }
}

