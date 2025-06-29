<?php

namespace App\Grid;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

/**
 * Class GridColumn
 *
 * Representa una columna individual en el Grid con soporte para múltiples tablas
 *
 * @package App\Grid
 */
class GridColumn implements Arrayable
{
    /**
     * @var string Label visible de la columna
     */
    private string $label;

    /**
     * @var string Alias único para evitar conflictos en joins
     */
    private string $alias;

    /**
     * Constructor de GridColumn
     *
     * @param string $column Nombre de la columna
     * @param string $table Nombre de la tabla a la que pertenece
     * @param GridColumnCollection $collection Colección padre
     */
    public function __construct(
        private string $column,
        private string $table,
        private GridColumnCollection $collection
    )
    {
        // Crear alias para evitar conflictos
        $this->alias = $this->table . '_' . $this->column;

        // Generar label inteligente
        if ($this->table !== $this->collection->getGrid()->getTableName()) {
            // Si es de otra tabla, incluir el nombre de la tabla
            $this->label = Str::ucfirst(Str::replace('_', ' ', $this->table)) . ' - ' .
                          Str::ucfirst(Str::replace('_', ' ', $this->column));
        } else {
            $this->label = Str::ucfirst(Str::replace('_', ' ', $this->column));
        }
    }

    /**
     * Obtiene el label de la columna
     *
     * @return string
     */
    public function getLabel(): string {
        return $this->label;
    }

    /**
     * Establece un label personalizado para la columna
     *
     * @param string $label Nuevo label
     * @return self
     */
    public function setLabel(string $label): self {
        $this->label = $label;
        return $this;
    }

    /**
     * Convierte la columna a array
     *
     * @return array{column: string, label: string, table: string, fullColumn: string, alias: string}
     */
    public function toArray(): array {
        return [
            'column' => $this->column,
            'label' => $this->label,
            'table' => $this->table,
            'fullColumn' => $this->table . '.' . $this->column,
            'alias' => $this->alias
        ];
    }
}
