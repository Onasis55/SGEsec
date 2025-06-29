<?php

namespace App\Http\Controllers;

use App\Grid\Grid;
use App\Models\Sancion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SancionController extends Grid
{
    protected string $modelClass = Sancion::class;

    protected string $title = 'Sanciones';

    protected string $page = 'Sanciones';

    protected string $resource  = 'sanciones';

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
            'tipo' => 'required|string'
        ];
    }
}
