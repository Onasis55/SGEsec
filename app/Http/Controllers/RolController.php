<?php

namespace App\Http\Controllers;

use App\Grid\Grid;
use App\Models\Rol;

class RolController extends Grid
{
    protected string $modelClass = Rol::class;

    protected string $title = 'Roles';

    protected string $page = 'Rol';
    protected string $resource  = 'roles';

    protected function defineRules(): array
    {
        return [
            'nombre' => 'required|string',
            'clave' => 'required|string',
            'descripcion' => 'required|string'
        ];
    }

    protected function defaultActions()
    {
        $this->rows
            ->actions
            ->addAction(
                'Editar',
                route($this->resource . '.edit', [';id;']),
                'bi-pencil-square'
            )
            ->addAction(
                'Eliminar',
                route($this->resource . '.show', [';id;']),
                'bi-trash'
            );

        $this->toolbar
            ->actions
            ->addAction(
                'Crear',
                route($this->resource . '.create'),
                'bi-plus-square'
            );

        // Debug: Ver acciones agregadas
        //dd($this->rows->actions->toArray());
    }

    protected function setupActions()
    {
        // TODO: Implement setupActions() method.
    }
}
