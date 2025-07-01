<?php

namespace Database\Seeders;

use App\Models\Grupo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Grupo::create([
            'clave' => '1°A'
        ]);
        Grupo::create([
            'clave' => '1°B'
        ]);
        Grupo::create([
            'clave' => '1°C'
        ]);
        Grupo::create([
            'clave' => '2°A'
        ]);
        Grupo::create([
            'clave' => '2°B'
        ]);
        Grupo::create([
            'clave' => '2°C'
        ]);
        Grupo::create([
            'clave' => '3°A'
        ]);
        Grupo::create([
            'clave' => '3°B'
        ]);
        Grupo::create([
            'clave' => '3°C'
        ]);
    }
}
