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
            $table->id();
            $table->decimal('valor', 5, 2);
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('unidad_id');
            $table->foreign('estudiante_id')->references('id')->on('estudiantes');
            $table->foreign('unidad_id')->references('id')->on('unidads');
            $table->timestamps();
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
