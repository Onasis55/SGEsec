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
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo',['inasistencia','conducta','seleccionar'])->default('seleccionar');
            $table->unsignedBigInteger('id_sanciones');
            $table->unsignedBigInteger('id_estudiante');
            $table->timestamps();

            $table->foreign('id_estudiante')->references('id')->on('estudiantes');
            $table->foreign('id_sanciones')->references('id')->on('sanciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
