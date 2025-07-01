<?php

namespace App\Http\Controllers;

use App\Grid\Grid;
use App\Models\Estudiante;
use App\Models\Rol;
use Illuminate\Http\Request;

class EstudianteController extends Grid
{

    protected string $modelClass = Estudiante::class;

    protected string $title = 'Estudiantes';

    protected string $page = 'Estudiantes';

    protected function defaultActions()
    {
        /** @var User $estudiantes */
        $estudiante = $this->getModel();
        $rolEstudiante = Rol::query()
            ->where('clave','=','estudiante')
            ->firstOrFail();
        $estudiante->where('rol_id',$rolEstudiante->id);
    }
}
