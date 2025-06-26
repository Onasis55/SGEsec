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

    public function create(): \Inertia\Response
    {
        return Inertia::render($this->page,[
            'url' => route($this->resource.'.store'),
            'method' => 'post',
            'backurl' => route($this->resource.'.index'),
        ]);
    }
    protected function defineRules(): array
    {
        return [
            'nombre' => 'required|string',
            'nivel' => 'required|integer|between:1,3'
        ];
    }
}
