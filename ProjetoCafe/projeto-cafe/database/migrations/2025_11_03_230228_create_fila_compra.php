<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fila_compra', function (Blueprint $table) {
            $table -> id();
            $table -> foreignId('usuario_id') -> constrained('usuario') -> onDelete('cascade');
            $table -> integer('posicao') -> notNullable();
            $table -> timestamps();
            $table -> softDeletes();
            $table -> unique(['usuario_id', 'deleted_at']);
            $table -> index('posicao');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fila_compra');
    }
};
