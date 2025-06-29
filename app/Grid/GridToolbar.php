<?php

namespace App\Grid;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Class GridToolbar
 *
 * Toolbar del Grid que contiene acciones globales
 *
 * @property-read GridActionCollection $actions Colección de acciones del toolbar
 *
 * @package App\Grid
 */
class GridToolbar implements Arrayable
{
    /**
     * @var GridActionCollection Colección de acciones
     */
    private GridActionCollection $actions;

    /**
     * Constructor de GridToolbar
     */
    public function __construct(){
        $this->actions = new GridActionCollection();
    }

    /**
     * Método mágico para obtener propiedades
     *
     * @param string $name Nombre de la propiedad
     * @return mixed|null
     */
    public function __get(string $name)
    {
        return match ($name) {
            'actions' => $this->actions,
            default => null,
        };
    }

    /**
     * Convierte el toolbar a array
     *
     * @return array{actions: array}
     */
    public function toArray(): array {
        return [
            'actions' => $this->actions->toArray(),
        ];
    }
}
