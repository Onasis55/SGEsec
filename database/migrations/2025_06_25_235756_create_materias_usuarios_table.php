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
        Schema::create('materias_users', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('materia_id');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('materia_id')->references('id')->on('materias');
            $table->timestamps();

            $table->unique(['usuario_id', 'materia_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materias_usuarios');
    }
};
