<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rol = Rol::where('clave', 'admin')->firstOrFail();
        User::create([
            'name' => 'admin',
            'apellido_paterno' => 'istrador',
            'email' => 'admin@sgesec.mx',
            'curp' => 'XAXX010101010101',
            'rol_id' => $rol->id,
            'cuenta' => 'A01',
            'password' => Hash::make('passwordadmin'),
        ]);
    }
}
