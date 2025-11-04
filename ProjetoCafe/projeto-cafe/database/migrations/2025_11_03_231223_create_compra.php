<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('compra', function (Blueprint $table) {
            $table -> id();
            $table -> foreignId('usuario_id') -> constraints('usuario');
            $table -> integer('cafe_qnd') -> nullable(false);
            $table -> integer('filtro_qnd') -> nullable(false);
            $table -> timestamps();
            $table -> softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compra');
    }
};
