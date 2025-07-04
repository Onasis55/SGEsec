<?php

namespace App\Grid;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @property-read array $links
 * @property-read GridActionCollection $actions
 */
class GridRowCollection implements Arrayable
{

    protected GridActionCollection $actions;


    protected LengthAwarePaginator $paginator;

    private array $rows = [];

    public function __construct(
        private int $page,
        private Grid $_grid
    )
    {
        $this->actions = new GridActionCollection();
        $this->init();
    }



    private function init(){
        /** @var Model $model */
        $model = $this->_grid->getModel();

        $calle = $this->_grid->getWhereClauses();

        if(!$model) throw new \Exception('Model not found');

        $builder = $model->newQuery();



        // Aplicar joins si existen
        $joins = $this->_grid->getJoins();
        foreach ($joins as $join) {
            switch ($join['type']) {
                case 'left':
                    $builder->leftJoin($join['table'], $join['first'], $join['operator'], $join['second']);
                    break;
                case 'right':
                    $builder->rightJoin($join['table'], $join['first'], $join['operator'], $join['second']);
                    break;
                case 'inner':
                default:
                    $builder->join($join['table'], $join['first'], $join['operator'], $join['second']);
                    break;
            }
        }

        if(is_callable($calle)){
            $calle($builder);
        }

        // Aplicamos los criterios de búsqueda
        $request = request();
        if($request->has('query') && $request->has('column')){
            $col = str_replace('-','.',$request->query('column'));
            $builder->where($col,'like','%'.$request->query('query').'%');
        }

        // Ordenar por la tabla principal para evitar conflictos
        $mainTable = $this->_grid->getTableName();
        $builder->orderBy($mainTable . '.id','DESC');

        $cols = $this->_grid->getColumns()->getKeys();

        // Si hay joins, necesitamos seleccionar columnas específicas para evitar conflictos
        if (!empty($joins)) {
            // Agregar el ID de la tabla principal para las acciones
            if (!in_array($mainTable . '.id', $cols)) {
                $cols[] = $mainTable . '.id';
            }
        }

        /** @var LengthAwarePaginator $paginator */
        $this->paginator = $builder->select($cols)->paginate(15);
        $this->paginator->withQueryString();

        foreach ($this->paginator->items() as $item) {
            $this->rows[] = new GridRow($item,$this);
        }

    }

    public function toArray(): array
    {
        return array_map(function (GridRow $row){
            return $row->toArray();
        },$this->rows);
    }

    public function __get(string $name): mixed
    {
        return match ($name) {
            'actions' => $this->actions,
            'links' => $this->paginator->linkCollection()->toArray(),
            default => null
        };
    }
}
