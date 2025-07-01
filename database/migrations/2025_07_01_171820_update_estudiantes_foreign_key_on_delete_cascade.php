<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEstudiantesForeignKeyOnDeleteCascade extends Migration
{
    public function up()
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            // Primero eliminar la clave foránea existente
            $table->dropForeign(['id_usuario']);

            // Luego agregar la clave foránea con onDelete('cascade')
            $table->foreign('id_usuario')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            // Revertir el cambio: eliminar la clave foránea con cascade
            $table->dropForeign(['id_usuario']);

            // Volver a agregar la clave foránea sin cascade (comportamiento por defecto restrict)
            $table->foreign('id_usuario')
                ->references('id')
                ->on('users');
        });
    }
}
