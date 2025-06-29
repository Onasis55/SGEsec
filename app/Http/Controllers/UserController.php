<?php

namespace App\Http\Controllers;

use App\Grid\UserGrid;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Inertia\Inertia;

class UserController extends UserGrid
{
    public function storeProfesor(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string',
            'curp' => 'required|string|size:18|unique:users,curp',
            'password' => 'nullable|string|min:6',
            'es_titular' => 'required|boolean',
        ]);

        $prefix = $data['es_titular'] ? 'BA' : 'BB';
        $randomDigits = str_pad(rand(0, 9999), 6, '0', STR_PAD_LEFT);
        $cuenta = $prefix . $randomDigits;

        $rol_id = $data['es_titular'] ? 2 : 5; // 2 titular, 5 sustituto

        $user = User::create([
            'cuenta' => $cuenta,
            'name' => $data['nombre'],
            'apellido_paterno' => $data['apellido_paterno'],
            'apellido_materno' => $data['apellido_materno'],
            'curp' => $data['curp'],
            'password' => bcrypt($data['password'] ?? Str::random(8)),
            'rol_id' => $rol_id,
        ]);

        return response()->json(['message' => 'Profesor creado', 'user' => $user]);
    }

    public function storeEstudiante(Request $request)
    {
        $data = $request->validate([
            'padre.nombre' => 'required|string',
            'padre.apellido_paterno' => 'required|string',
            'padre.apellido_materno' => 'required|string',
            'padre.curp' => 'required|string|size:18|unique:users,curp',
            'padre.password' => 'nullable|string|min:6',
            'estudiante.nombre' => 'required|string',
            'estudiante.apellido_paterno' => 'required|string',
            'estudiante.apellido_materno' => 'required|string',
            'estudiante.curp' => 'required|string|size:18|unique:users,curp',
            'estudiante.password' => 'nullable|string|min:6',
        ]);

        $cuentaEstudiante = 'C' . substr($data['estudiante']['curp'], 0, 10);

        $homoclave = $this->generarHomoclaveUnica();

        $cuentaPadre = 'C' . substr($data['estudiante']['curp'], 0, 10) . $homoclave;

        $padre = User::create([
            'cuenta' => $cuentaPadre,
            'name' => $data['padre']['nombre'],
            'apellido_paterno' => $data['padre']['apellido_paterno'],
            'apellido_materno' => $data['padre']['apellido_materno'],
            'curp' => $data['padre']['curp'],
            'password' => bcrypt($data['padre']['password'] ?? Str::random(8)),
            'rol_id' => 3, // Asumiendo rol padre/tutor
        ]);

        $estudiante = User::create([
            'cuenta' => $cuentaEstudiante,
            'name' => $data['estudiante']['nombre'],
            'apellido_paterno' => $data['estudiante']['apellido_paterno'],
            'apellido_materno' => $data['estudiante']['apellido_materno'],
            'curp' => $data['estudiante']['curp'],
            'password' => bcrypt($data['estudiante']['password'] ?? Str::random(8)),
            'rol_id' => 4, // Asumiendo rol estudiante
        ]);

        return response()->json(['message' => 'Estudiante y padre creados', 'padre' => $padre, 'estudiante' => $estudiante]);
    }

    private function generarHomoclaveUnica()
    {
        do {
            $homoclave = $this->generarHomoclave();
        } while (User::where('cuenta', 'like', '%' . $homoclave)->exists());

        return $homoclave;
    }

    private function generarHomoclave()
    {
        $letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $digitos = '0123456789';

        if (rand(0,1) === 0) {
            return $digitos[rand(0,9)] . $digitos[rand(0,9)] . $letras[rand(0,25)];
        } else {
            return $digitos[rand(0,9)] . $letras[rand(0,25)] . $letras[rand(0,25)];
        }
    }

    public function show($id, Request $request)
    {
        $item = $this->modelClass::findOrFail($id);

        return Inertia::render('UsuarioDelete', [
            'item' => $item,
            'url' => route($this->resource . '.destroy', [$id]),
            'method' => 'delete',
            'backurl' => route($this->resource . '.index'),
        ]);
    }

    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string',
            'curp' => 'required|string|size:18|unique:users,curp,' . $id,
            'password' => 'nullable|string|min:6',
            'rol_id' => 'required|integer|in:2,5,4', // 2 titular, 5 sustituto, 4 estudiante
        ]);

        $oldRol = $user->rol_id;
        $newRol = $data['rol_id'];

        if (($oldRol == 2 && $newRol == 5) || ($oldRol == 5 && $newRol == 2)) {
            // Cambió entre titular y sustituto, actualizar cuenta

            $oldCuenta = $user->cuenta;
            $digits = substr($oldCuenta, 2); // Extrae los últimos 6 dígitos

            $prefix = $newRol == 2 ? 'BA' : 'BB';

            $data['cuenta'] = $prefix . $digits;
        }

        $user->name = $data['name'];
        $user->apellido_paterno = $data['apellido_paterno'];
        $user->apellido_materno = $data['apellido_materno'];
        $user->curp = $data['curp'];
        $user->rol_id = $data['rol_id'];

        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        if (isset($data['cuenta'])) {
            $user->cuenta = $data['cuenta'];
        }

        $user->save();

        return response()->json(['message' => 'Usuario actualizado', 'user' => $user]);
    }
}
