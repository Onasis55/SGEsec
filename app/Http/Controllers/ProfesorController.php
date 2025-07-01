<?php

namespace App\Http\Controllers;

use App\Grid\Grid;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProfesorController extends Grid
{
    protected string $modelClass = User::class;

    protected string $title = 'Profesores';

    protected string $page = 'Profesores';

    protected string $resource  = 'profesores';



    protected function mounted()
    {
        $this->setWhereClause(function (Builder $builder){
            /** @var User $profesores */
            $rolProfesor = Rol::query()
                ->where('clave', '=', 'profesortitular')
                ->firstOrFail();
            $builder->where('rol_id', $rolProfesor->id);
        });

    }

}
