<?php

namespace App\Grid;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GridRow
 *
 * Representa una fila individual del Grid
 *
 * @package App\Grid
 */
class GridRow implements Arrayable
{
    /**
     * @var GridActionCollection Acciones disponibles para esta fila
     */
    private GridActionCollection $actions;

    /**
     * Constructor de GridRow
     *
     * @param Model $rowitem Modelo de la fila
     * @param GridRowCollection $collection Colección padre
     */
    public function __construct(
        private Model $rowitem,
        private GridRowCollection $collection
    ) {}

    /**
     * Convierte la fila a array, procesando las acciones con valores dinámicos
     *
     * @return array{data: array, actions: array}
     */
    public function toArray(): array {
        $actions = $this->collection->actions->toArray();
        $formatedActions = [];
        foreach ($actions as $action) {
            $route = $action['url'];
            $keys = [];
            preg_match_all('/(?<=;)[^;]+(?=;)/', $route, $keys);
            $keys = $keys[0];
            foreach ($keys as $key) {
                $val = $this->rowitem->{$key};
                $route = str_replace(";{$key};",$val,$route);
            }
            $action['url'] = $route;
            $formatedActions[] = $action;
        }
        return [
            'data' => $this->rowitem->toArray(),
            'actions' => $formatedActions,
        ];
    }
}
