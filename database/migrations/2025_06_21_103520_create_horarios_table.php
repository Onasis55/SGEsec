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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id('id_horario');
            $table->time('hora_ini');
            $table->time('hora_fin');
            $table->enum('dia', [
                'lunes',
                'martes',
                'miercoles',
                'jueves',
                'viernes',
                'sin asignar']
            )->default('sin asignar');

            $table->string('periodo');
            $table->unsignedBigInteger('id_materia');
            $table->unsignedBigInteger('id_profesor');
            $table->timestamps();

            $table->foreign('id_profesor')
                ->references('id_profesor')
                ->on('profesors')
                ->onDelete('cascade');

            $table->foreign('id_materia')
                ->references('id_materia')
                ->on('materias')
                ->onDelete('cascade');

            $table->foreign('periodo')
                ->references('periodo')
                ->on('ciclo_escolars')
                ->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
