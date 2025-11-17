<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compra', function (Blueprint $table) {
            $table -> id();
            $table -> foreignId('usuario_id') -> constrained('usuario') -> onDelete('cascade');
            $table -> foreignId('fila_id') -> constrained('fila_compra') -> onDelete('cascade');
            $table -> integer('cafe_qnd') -> notNullable();
            $table -> integer('filtro_qnd') -> default(0);
            $table -> timestamps();
            $table -> softDeletes();
            $table -> index(['usuario_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compra');
    }
};
