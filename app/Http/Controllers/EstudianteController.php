<?php

namespace App\Http\Controllers;

use App\Grid\Grid;
use App\Models\Estudiante;
use App\Models\Rol;
use App\Models\User;
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
        $this->addJoin(
            'users',
            'users.id',
            '=',
            'estudiantes.id_usuario',
            [
                'users.name', 'users.rol_id'
            ]
        );

        $this->setWhereClause(function (Builder $builder){
            /** @var Estudiante $estudiantes */
            $rolEstudiante = Rol::query()
                ->where('clave','=','estudiante')
                ->firstOrFail();
            $builder->where('users.rol_id', $rolEstudiante->id);
        });
    }
    protected function defaultActions(){}
}
