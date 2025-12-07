<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_usuario', function (Blueprint $table) {
            $table -> id();
            $table -> foreignId('usuario_id') -> constrained('usuario') -> onDelete('cascade');
            $table -> enum('tipo_evento', ['login', 'logout']) -> default('login');
            $table -> dateTime('data_evento') -> nullable(false);
            $table -> string('ip_address') -> nullable();
            $table -> string('user_agent') -> nullable();
            $table -> timestamps();
            $table -> softDeletes();
            $table -> index(['usuario_id', 'data_evento']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_usuario');
    }
};