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


    protected function defineRules(): array
    {
        return [
            'tipo' => 'required|string'
        ];
    }
}
