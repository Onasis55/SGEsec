<?php

namespace App\Http\Controllers;

use App\Grid\Grid;
use App\Models\Reporte;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReporteController extends Grid
{
    protected string $modelClass = Reporte::class;

    protected string $title = 'Reportes';

    protected string $page = 'TipoReportes';

    protected string $resource  = 'reportes';

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
            'tipo' => 'required|string',
            'descripcion' => 'required|string',
        ];
    }
}
