<?php

namespace App\Http\Controllers;

use App\Grid\Grid;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Grid
{
    protected string $modelClass = Rol::class;

    protected string $title = 'Roles de Usuarios';

    protected string $page = 'Rol';

    protected string $resource  = 'roles';
}
