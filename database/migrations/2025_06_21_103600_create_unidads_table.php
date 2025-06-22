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
            $table->id('id_unidad');
            $table->string('nombre');
            $table->integer('orden');
            $table->unsignedBigInteger('id_materia');
            $table->timestamps();

            $table->foreign('id_materia')
                ->references('id_materia')
                ->on('materias')
                ->ondelete('cascade');
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
