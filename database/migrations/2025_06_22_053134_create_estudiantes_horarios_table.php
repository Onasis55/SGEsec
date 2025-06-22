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
        Schema::create('estudiantes_horarios', function (Blueprint $table) {
            $table->string('boleta');
            $table->unsignedBigInteger('id_horario');
            $table->timestamps();

            $table->primary(['id_horario', 'boleta']);

            $table->foreign('boleta')
                ->references('boleta')
                ->on('estudiantes')
                ->onDelete('cascade');

            $table->foreign('id_horario')
                ->references('id_horario')
                ->on('horarios')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes_horarios');
    }
};
