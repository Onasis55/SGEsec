<?php

namespace App\Grid;

use Illuminate\Contracts\Support\Arrayable;

class GridColumnCollection implements Arrayable
{
    private array $columns;
    private $_grid;

    public function __construct(
        array $columns,
        Grid $grid
    ){
        $this->_grid = $grid;  // Asignar primero

        $tableName = $grid->getTableName();
        $joinColumns = $grid->getJoinColumns();

        foreach ($columns as $column){
            if(gettype($column) != 'string')
                throw new \Exception("Todas las columnas deben ser string [$column]");

            // Verificar si la columna ya tiene el formato tabla.columna o es un alias
            if (strpos($column, '.') !== false || strpos($column, ' as ') !== false) {
                // Es una columna con join o alias, usar tal como está
                $colkey = $column;

                // Extraer el nombre de la columna para el objeto GridColumn
                $columnName = $column;
                $tableForColumn = '';

                if (strpos($column, ' as ') !== false) {
                    // Es un alias, extraer el alias como nombre de columna
                    $parts = explode(' as ', $column);
                    $columnName = trim($parts[1]);
                    $tableForColumn = explode('.', trim($parts[0]))[0] ?? '';
                } else if (strpos($column, '.') !== false) {
                    // Es tabla.columna
                    $parts = explode('.', $column);
                    $columnName = $parts[1];
                    $tableForColumn = $parts[0];
                } else {
                    $tableForColumn = $tableName;
                }

                $this->columns[$colkey] = new GridColumn($columnName, $tableForColumn, $this);
            } else {
                // Es una columna de la tabla principal
                $colkey = $tableName . '.' . $column;
                $this->columns[$colkey] = new GridColumn($column, $tableName, $this);
            }
        }
    }

    public function getGrid(): Grid {
        return $this->_grid;
    }

    public function toArray(): array
    {
        return array_map(function (GridColumn $column){
            return $column->toArray();
        }, $this->columns);
    }

    public function getKeys(): array
    {
        return array_keys($this->columns);
    }


}
