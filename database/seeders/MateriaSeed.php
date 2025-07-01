<?php

namespace Database\Seeders;

use App\Models\Materia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MateriaSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Materia::create([
            'clave' => 'ING1',
            'nombre' => 'Ingles',
            'nivel' => '1',
            'descripcion' => 'Materia ingles'
        ]);
        Materia::create([
            'clave' => 'ING2',
            'nombre' => 'Ingles',
            'nivel' => '2',
            'descripcion' => 'Materia ingles'
        ]);
        Materia::create([
            'clave' => 'ING3',
            'nombre' => 'Ingles',
            'nivel' => '3',
            'descripcion' => 'Materia ingles'
        ]);
        Materia::create([
            'clave' => 'MAT1',
            'nombre' => 'Matemáticas',
            'nivel' => '1',
            'descripcion' => 'Materia matemáticas'
        ]);
        Materia::create([
            'clave' => 'MAT2',
            'nombre' => 'Matemáticas',
            'nivel' => '2',
            'descripcion' => 'Materia matemáticas'
        ]);
        Materia::create([
            'clave' => 'MAT3',
            'nombre' => 'Matemáticas',
            'nivel' => '3',
            'descripcion' => 'Materia matemáticas'
        ]);
        Materia::create([
            'clave' => 'ESP1',
            'nombre' => 'Español',
            'nivel' => '1',
            'descripcion' => 'Materia español'
        ]);
        Materia::create([
            'clave' => 'ESP2',
            'nombre' => 'Español',
            'nivel' => '2',
            'descripcion' => 'Materia español'
        ]);
        Materia::create([
            'clave' => 'ESP3',
            'nombre' => 'Español',
            'nivel' => '3',
            'descripcion' => 'Materia español'
        ]);
        Materia::create([
            'clave' => 'HIS1',
            'nombre' => 'Historia',
            'nivel' => '1',
            'descripcion' => 'Materia historia'
        ]);
        Materia::create([
            'clave' => 'HIS2',
            'nombre' => 'Historia',
            'nivel' => '2',
            'descripcion' => 'Materia historia'
        ]);
        Materia::create([
            'clave' => 'HIS3',
            'nombre' => 'Historia',
            'nivel' => '3',
            'descripcion' => 'Materia historia'
        ]);
        Materia::create([
            'clave' => 'GEO1',
            'nombre' => 'Geografía',
            'nivel' => '1',
            'descripcion' => 'Materia geografia'
        ]);
        Materia::create([
            'clave' => 'GEO2',
            'nombre' => 'Geografía',
            'nivel' => '2',
            'descripcion' => 'Materia geografia'
        ]);
        Materia::create([
            'clave' => 'GEO3',
            'nombre' => 'Geografía',
            'nivel' => '3',
            'descripcion' => 'Materia geografia'
        ]);
        Materia::create([
            'clave' => 'SOC1',
            'nombre' => 'Sociales',
            'nivel' => '1',
            'descripcion' => 'Materia sociales'
        ]);
        Materia::create([
            'clave' => 'SOC2',
            'nombre' => 'Sociales',
            'nivel' => '2',
            'descripcion' => 'Materia sociales'
        ]);
        Materia::create([
            'clave' => 'SOC3',
            'nombre' => 'Sociales',
            'nivel' => '3',
            'descripcion' => 'Materia sociales'
        ]);


    }
}
