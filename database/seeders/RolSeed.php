<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::create([
            'nombre' => 'Administrador',
            'clave' => 'admin'
        ]);
        Rol::create(
        [
            'nombre' => 'Profesor Titular',
            'clave' => 'profesortitular'
        ]);
        Rol::create(
        [
            'nombre' => 'Padre o Tutor',
            'clave' => 'tutor'
        ]);
        Rol::create(
        [
            'nombre' => 'Estudiante',
            'clave' => 'estudiante'
        ]);
        Rol::create(
        [
            'nombre' => 'Profesor Sustituto',
            'clave' => 'profesorsustituto'
        ]);
    }
}
