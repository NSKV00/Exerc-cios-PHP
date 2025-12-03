<?php

namespace App\Models;

use App\Traits\SerializesDatetime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogUsuario extends Model
{
    use SoftDeletes, SerializesDatetime;

    protected $table = 'log_usuario';
    protected $primaryKey = 'id';
    protected $fillable = ['usuario_id', 'data_acesso'];
    public $timestamps = true;

    protected function casts(): array
    {
        return [
            'data_acesso' => 'datetime',
            'usuario_id' => 'integer',
        ];
    }

    public function Usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
