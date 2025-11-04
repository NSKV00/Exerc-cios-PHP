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
        Schema::create('usuario', function (Blueprint $table) {
            $table -> id();
            $table -> string('nome') -> nullable(false);
            $table -> string('email') -> unique() -> nullable(false);
            $table -> string('senha') -> nullable(false);
            $table -> string('acesso') -> default('usuario') -> nullable(false);
            $table -> timestamps();
            $table -> softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
