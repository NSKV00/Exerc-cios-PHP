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
        Schema::table('vendas', function(Blueprint $table) {
            $table -> integer('ingresso_id');
            $table -> decimal('valor');
            $table -> integer('evento_id');
            $table -> string('documento', length:11) -> nullable(false);
            $table -> foreign('ingresso_id')->references('id') -> on('ingressos');
            $table -> foreign('evento_id')->references('id')->on('eventos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendas', function (Blueprint $table) {
            $table -> dropForeign(['ingresso_id']);
            $table -> dropColumn('ingresso_id');
            $table -> dropColumn('valor');
            $table -> dropForeign(['evento_id']);
            $table -> dropColumn('evento_id');
            $table -> dropColumn('documento');
        });
    }
};
