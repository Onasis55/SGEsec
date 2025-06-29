<?php

namespace App\Http\Controllers;

use App\Grid\Grid;
use App\Models\Calificacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalificacionController extends Grid
{
    protected string $modelClass = Calificacion::class;

    protected string $title = 'Calificaciones';

    protected string $page = 'Calificaciones';

    protected string $resource  = 'calificaciones';

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
            'valor' => 'required|string'
        ];
    }
}
