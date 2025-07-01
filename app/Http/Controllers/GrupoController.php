<?php

namespace App\Http\Controllers;

use App\Grid\Grid;
use App\Models\Grupo;
use Illuminate\Database\Eloquent\Builder;

class GrupoController extends Grid
{
    protected string $modelClass = Grupo::class;

    protected string $title = 'Grupos';

    protected string $page = 'Grupos';

    protected string $resource = 'grupos';

    protected function mounted()
    {
        // Puedes agregar joins o filtros si es necesario
    }
}
