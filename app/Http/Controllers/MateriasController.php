<?php

namespace App\Http\Controllers;

use App\Grid\Grid;
use App\Models\Materia;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MateriasController extends Grid
{
    protected string $modelClass = Materia::class;

    protected string $title = 'Materias';

    protected string $page = 'Materias';

    protected string $resource  = 'materias';


    protected function defineRules(): array
    {
        return [
            'nombre' => 'required|string',
            'nivel' => 'required|integer|between:1,3'
        ];
    }

    protected function defaultActions()
    {
        // TODO: Implement defaultActions() method.
    }

    protected function setupActions()
    {
        // TODO: Implement setupActions() method.
    }
}
