<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fila extends Model
{
    use SoftDeletes;
    protected $table = 'fila_compra';
    protected $primaryKey = 'id';
}
