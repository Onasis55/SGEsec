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
        Schema::table('horario_items', function (Blueprint $table) {
            $table->unsignedTinyInteger('dia_semana')->after('grupo_id'); // 0=lunes ... 4=viernes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('horario_items', function (Blueprint $table) {
            $table->dropColumn('dia_semana');
        });
    }
};
