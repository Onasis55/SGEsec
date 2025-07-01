<?php

namespace App\Http\Controllers;

use App\Grid\Grid;
use App\Models\Horario;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HorarioControllerOld extends Grid
{
    protected string $modelClass = Horario::class;

    protected string $title = 'Horarios';

    protected string $page = 'Horarios';

    protected string $resource  = 'horarios';

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
            'hora_ini' => 'required|string',
            'hora_fin' => 'required|string'
        ];
    }
}
