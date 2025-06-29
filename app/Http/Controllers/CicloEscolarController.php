<?php

namespace App\Http\Controllers;

use App\Grid\Grid;
use App\Models\CicloEscolar;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CicloEscolarController extends Grid
{
    protected string $modelClass = CicloEscolar::class;

    protected string $title = 'CiclosEscolares';

    protected string $page = 'VistaReportes';

    protected string $resource = 'ciclosescolares';

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
            'ciclo' => 'required|string',
            'fecha_ini' => 'required|date',
            'fecha_fin' => 'required|date'
        ];
    }
}
