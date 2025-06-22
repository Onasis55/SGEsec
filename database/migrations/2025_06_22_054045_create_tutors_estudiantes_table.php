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
        Schema::create('tutors_estudiantes', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tutor');
            $table->string('boleta');
            $table->timestamps();

            $table->primary(['id_tutor', 'boleta']);

            $table->foreign('id_tutor')
                ->references('id_tutor')
                ->on('tutors')
                ->onDelete('cascade');

            $table->foreign('boleta')
                ->references('boleta')
                ->on('estudiantes')
                ->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutors_estudiantes');
    }
};
