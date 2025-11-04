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
        Schema::create('log_alteracao', function (Blueprint $table) {
            $table -> id();
            $table -> foreignId('compra_id') -> constraints('compra');
            $table -> foreignId('usuario_id') -> constraints('usuario');
            $table -> dateTime('data_alteracao') -> nullable(false);
            $table -> string('detalhes') -> nullable(true);
            $table -> timestamps();
            $table -> softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_alteracao');
    }
};
