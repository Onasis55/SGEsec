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
        Schema::create('materias_usuarios', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('materias_id');
            $table->unsignedBigInteger('usuarios_id');
            $table->foreign('materias_id')->references('id')->on('materias');
            $table->foreign('usuarios_id')->references('id')->on('users');
            $table->timestamps();

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
