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
        Schema::create('calificacions', function (Blueprint $table) {
            $table->id('id_calificacion');
            $table->decimal('valor', 5, 2);
            $table->date('fecha_registro');
            $table->string('boleta');
            $table->unsignedBigInteger('id_materia');
            $table->unsignedBigInteger('id_unidad');
            $table->string('periodo');
            $table->timestamps();

            $table->foreign('boleta')
                ->references('boleta')
                ->on('estudiantes')
                ->ondelete('cascade');

            $table->foreign('id_materia')
                ->references('id_materia')
                ->on('materias')
                ->onDelete('cascade');

            $table->foreign('id_unidad')
                ->references('id_unidad')
                ->on('unidads')
                ->onDelete('cascade');

            $table->foreign('periodo')
                ->references('periodo')
                ->on('ciclo_escolars')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificacions');
    }
};
