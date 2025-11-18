<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('compra', function (Blueprint $table) {
            $table->foreignId('fila_id')
                  ->nullable()
                  ->constrained('fila_compra')
                  ->onDelete('cascade')
                  ->after('usuario_id');
        });
    }

    public function down(): void
    {
        Schema::table('compra', function (Blueprint $table) {
            $table->dropForeign(['fila_id']);
            $table->dropColumn('fila_id');
        });
    }
};
