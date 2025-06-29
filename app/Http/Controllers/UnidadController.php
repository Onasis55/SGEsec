<?php

namespace App\Http\Controllers;

use App\Grid\Grid;
use App\Models\Unidad;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UnidadController extends Grid
{
    protected string $modelClass = Unidad::class;

    protected string $title = 'Unidades';

    protected string $page = 'Unidades';

    protected string $resource = 'unidades';

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
