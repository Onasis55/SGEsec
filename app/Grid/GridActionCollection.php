<?php

namespace App\Grid;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Class GridActionCollection
 *
 * Colección de acciones del Grid
 *
 * @package App\Grid
 */
class GridActionCollection implements Arrayable
{
    /**
     * @var array<GridAction> Array de acciones
     */
    private array $actions = [];

    /**
     * Agrega una nueva acción a la colección
     *
     * @param string $label Etiqueta de la acción
     * @param string $url URL de la acción
     * @param string $icon Icono de la acción
     * @return self
     */
    final public function addAction(
        string $label,
        string $url,
        string $icon
    ): GridActionCollection
    {
        $this->actions[] = new GridAction($label, $icon,$url);
        return $this;
    }

    /**
     * Convierte la colección a array
     *
     * @return array
     */
    public function toArray(): array {
        return array_map(function (GridAction $action) {
            return $action->toArray();
        },$this->actions);
    }
}
