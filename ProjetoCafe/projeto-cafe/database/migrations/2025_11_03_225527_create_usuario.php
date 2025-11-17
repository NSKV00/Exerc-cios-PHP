<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table -> id();
            $table -> string('nome', 100) -> notNullable();
            $table -> string('email', 100) -> unique() -> notNullable();
            $table -> string('senha', 255) -> notNullable();
            $table -> enum('acesso', ['usuario', 'admin'])->default('usuario');
            $table -> timestamps();
            $table -> softDeletes();
            $table -> index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
