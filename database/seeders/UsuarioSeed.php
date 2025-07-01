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
        $rola = Rol::where('clave', 'admin')->firstOrFail();
        User::create([
            'name' => 'admin',
            'apellido_paterno' => 'istrador',
            'email' => 'admin@sgesec.mx',
            'curp' => 'XAXX010101010101',
            'rol_id' => $rola->id,
            'cuenta' => 'A01',
            'password' => Hash::make('passwordadmin'),
        ]);
        $rolB = Rol::where('clave', 'profesortitular')->firstOrFail();
        User::create([
            'name' => 'Juan',
            'apellido_paterno' => 'Mendoza',
            'email' => 'profejuan@sgesec.mx',
            'curp' => 'OVWJ111117HCSEQV86',
            'rol_id' => $rolB->id,
            'cuenta' => 'BA000001',
            'password' => Hash::make('123456789'),
        ]);
        $rolC = Rol::where('clave', 'tutor')->firstOrFail();
        User::create([
            'name' => 'Pepe',
            'apellido_paterno' => 'Medina',
            'email' => 'pepemedina@sgesec.mx',
            'curp' => 'PZPA260308MSRGBN53',
            'rol_id' => $rolC->id,
            'cuenta' => 'CPZPA260308A00',
            'password' => Hash::make('123456789'),
        ]);
        $rolD = Rol::where('clave', 'estudiante')->firstOrFail();
        User::create([
            'name' => 'Santiago',
            'apellido_paterno' => 'Lopez',
            'email' => 'slopezm@sgesec.mx',
            'curp' => 'YBWD360805MSLWTH48',
            'rol_id' => $rolD->id,
            'cuenta' => 'CYBWD360805',
            'password' => Hash::make('123456789'),
        ]);
        $rolE = Rol::where('clave', 'profesorsustituto')->firstOrFail();
        User::create([
            'name' => 'Angel',
            'apellido_paterno' => 'Carrillo',
            'email' => 'profecarrillo@sgesec.mx',
            'curp' => 'XVBT740912HYNNFN82',
            'rol_id' => $rolE->id,
            'cuenta' => 'BB000001',
            'password' => Hash::make('123456789'),
        ]);
    }
}
