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
        Schema::create('unidads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_estudiante');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_materia');
            $table->unsignedBigInteger('id_horario');
            $table->unsignedBigInteger('id_calificacion');
            $table->timestamps();

            $table->foreign('id_estudiante')->references('id')->on('estudiantes');
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->foreign('id_materia')->references('id')->on('materias');
            $table->foreign('id_horario')->references('id')->on('horarios');
            $table->foreign('id_calificacion')->references('id')->on('calificacions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidads');
    }
};
