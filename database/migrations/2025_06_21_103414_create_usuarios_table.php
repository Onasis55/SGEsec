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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('cuenta')
                ->unique();
            $table->string('password');
            $table->string('nombre');
            $table->string('ap_pat');
            $table->string('ap_mat')
                ->nullable();
            $table->boolean('activo')
                ->default(true);
            $table->unsignedBigInteger('id_rol');
            $table->timestamps();

            $table->foreign('id_rol')
                ->references('id_rol')
                ->on('rols')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
