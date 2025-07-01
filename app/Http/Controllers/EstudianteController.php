<?php

namespace App\Http\Controllers;

use App\Grid\Grid;
use App\Models\Estudiante;
use App\Models\Rol;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;


class EstudianteController extends Grid
{

    protected string $modelClass = Estudiante::class;

    protected string $title = 'Estudiantes';

    protected string $page = 'Estudiantes';

    protected string $resource = 'estudiantes';

    protected function mounted()
    {
        $this->setWhereClause(function (Builder $builder){
            /** @var User $estudiantes */
            $estudiante = Rol::query()
                ->where('clave','=','estudiante')
                ->firstOrFail();
            $builder->where('rol_id',$estudiante->id);
        });
    }
    protected function defaultActions()
    {
    }
}
