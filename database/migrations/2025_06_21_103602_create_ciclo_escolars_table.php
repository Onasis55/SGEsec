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
        Schema::create('ciclo_escolars', function (Blueprint $table) {
            $table->id();
            //$table->string('ciclo');
            $table->date('fecha_ini');
            $table->date('fecha_fin');
            $table->unsignedBigInteger('materia_id');
            $table->timestamps();

            $table->foreign('materia_id')->references('id')->on('materias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciclo_escolars');
    }
};
