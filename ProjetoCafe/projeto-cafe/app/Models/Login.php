<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogUsuario extends Model
{
    use SoftDeletes;

    protected $table = 'log_usuario';
    protected $primaryKey = 'id';
    protected $fillable = ['usuario_id', 'data_acesso'];
    public $timestamps = true;

    protected function casts(): array
    {
        return [
            'data_acesso' => 'datetime',
        ];
    }

    public function Usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
