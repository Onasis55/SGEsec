<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('horarios', function (Blueprint $table) {
            $table->dropColumn('hora_ini');
            $table->dropColumn('hora_fin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('horarios', function (Blueprint $table) {
            // Si necesitas revertir, define cómo recrear las columnas
            $table->time('hora_ini')->nullable(); // O como estaban originalmente
            $table->time('hora_fin')->nullable(); // O como estaban originalmente
        });
    }
};
