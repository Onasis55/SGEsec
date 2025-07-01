<?php

namespace App\Grid;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

abstract class Grid extends Controller
{
    protected string $modelClass;
    protected string $title;
    protected string $resource;
    private GridToolbar $toolbar;

    private mixed $whereClause = null;

    protected string $page;

    protected string $view = 'Grid';
    protected GridColumnCollection $columns;
    protected GridRowCollection $rows;
    private string $_table;
    private Model $_model;
    protected bool $excludeStamps = true;

    protected array $joins = [];
    protected array $joinColumns = [];

    /**
     * Define el formulario de edición personalizado.
     * Si se retorna null, se usa el formulario por defecto (this->page).
     * En clases hijas se puede sobreescribir para retornar otro componente Vue.
     */
    protected function getEditFormPage(): ?string
    {
        return null;
    }

    final protected function init()
    {
        $conn = DB::connection();
        $schemaBuilder = $conn->getSchemaBuilder();
        $this->_model = (new $this->modelClass);
        $this->_table = $this->_model->getTable();

        $this->mounted();


        if (!empty($this->visibleColumns)) {
            $columns = $this->visibleColumns;
        } else {
            $columns = $schemaBuilder->getColumnListing($this->_table);
            if ($this->excludeStamps)
                $columns = array_diff($columns, ['created_at', 'updated_at']);
        }

        if (!empty($this->joinColumns)) {
            $columns = array_merge($columns, $this->joinColumns);
        }



        $this->columns = new GridColumnCollection($columns, $this);


        $this->rows = new GridRowCollection(
            intval(request('page', 1)),
            $this
        );


        $this->toolbar = new GridToolbar();
        $this->defaultActions();
    }

    /**
     * Método para definir joins
     * Ejemplo: $this->addJoin('users', 'posts.user_id', '=', 'users.id', ['users.name as user_name', 'users.email as user_email'])
     */
    protected function addJoin(string $table, string $first, string $operator, string $second, array $selectColumns = []): void
    {
        $this->joins[] = [
            'table' => $table,
            'first' => $first,
            'operator' => $operator,
            'second' => $second,
            'type' => 'inner'
        ];

        if (!empty($selectColumns)) {
            $this->joinColumns = array_merge($this->joinColumns, $selectColumns);
        }
    }

    /**
     * Método para definir left joins
     */
    protected function addLeftJoin(string $table, string $first, string $operator, string $second, array $selectColumns = []): void
    {
        $this->joins[] = [
            'table' => $table,
            'first' => $first,
            'operator' => $operator,
            'second' => $second,
            'type' => 'left'
        ];

        if (!empty($selectColumns)) {
            $this->joinColumns = array_merge($this->joinColumns, $selectColumns);
        }
    }

    /**
     * Método para definir right joins
     */
    protected function addRightJoin(string $table, string $first, string $operator, string $second, array $selectColumns = []): void
    {
        $this->joins[] = [
            'table' => $table,
            'first' => $first,
            'operator' => $operator,
            'second' => $second,
            'type' => 'right'
        ];

        if (!empty($selectColumns)) {
            $this->joinColumns = array_merge($this->joinColumns, $selectColumns);
        }
    }

    /**
     * Método abstracto para definir props extras del formulario
     * Debe ser implementado en las clases hijas
     * @return array
     */
    protected function getFormExtraProps(): array
    {
        return [];
    }

    /**
     * Obtener los joins definidos
     */
    public function getJoins(): array
    {
        return $this->joins;
    }

    /**
     * Obtener las columnas de joins
     */
    public function getJoinColumns(): array
    {
        return $this->joinColumns;
    }

    /**
     * Método para inicializar la clase hija
     */
    protected function mounted()
    {
    }

    /**
     * Define las acciones por defecto para filas y toolbar
     */
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
    }

    final public function index()
    {
        $this->init();
        return Inertia::render($this->view, $this->toArray());
    }

    public function create()
    {
        return Inertia::render($this->page, array_merge([
            'url' => route($this->resource . '.store'),
            'method' => 'post',
            'backurl' => route($this->resource . '.index'),
        ], $this->getFormExtraProps()));
    }

    protected function setWhereClause(callable $calle){
        $this->whereClause = $calle;
    }

    public function store(Request $request)
    {
        $rules = $this->defineRules();
        if (count($rules) > 0)
            $request->validate($rules);

        $item = $this->modelClass::create($request->all());

        if (!$item)
            throw new \Exception('No fue posible crear el registro');

        return response()->json([
            'url' => route($this->resource . '.index')
        ]);
    }

    public function edit($id, Request $request)
    {
        $item = $this->modelClass::findOrFail($id);

        $editPage = $this->getEditFormPage() ?? $this->page;

        return Inertia::render($editPage, array_merge([
            'item' => $item,
            'url' => route($this->resource . '.update', [$id]),
            'method' => 'put',
            'backurl' => route($this->resource . '.index'),
        ], $this->getFormExtraProps()));
    }

    public function show($id, Request $request)
    {
        $item = $this->modelClass::findOrFail($id);

        return Inertia::render($this->page, array_merge([
            'item' => $item,
            'url' => route($this->resource . '.destroy', [$id]),
            'method' => 'delete',
            'destroy' => true,
            'backurl' => route($this->resource . '.index'),
        ], $this->getFormExtraProps()));
    }

    public function update($id, Request $request)
    {
        $item = $this->modelClass::findOrFail($id);

        $attr = $request->except('_method');

        foreach ($attr as $key => $value) {
            $item->{$key} = $value;
        }

        $item->save();

        return response()->json([
            'url' => route($this->resource . '.index')
        ]);
    }

    public function destroy($id, Request $request)
    {
        $this->modelClass::destroy($id);
        return response()->json([
            'url' => route($this->resource . '.index')
        ]);
    }

    protected function defineRules(): array
    {
        return [];
    }

    public function getTableName(): string
    {
        return $this->_table;
    }

    public function getModel(): Model
    {
        return $this->_model;
    }

    public function getModelClass(): string
    {
        return $this->modelClass;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'columns' => $this->columns->toArray(),
            'rows' => $this->rows->toArray(),
            'toolbar' => $this->toolbar->toArray(),
            'pagination' => [
                'links' => $this->rows->links
            ]
        ];
    }

    public function getColumns(): GridColumnCollection
    {
        return $this->columns;
    }

    public function getWhereClauses(): mixed
    {
        return $this->whereClause;
    }

    public function __get(string $name)
    {
        return match ($name) {
            'toolbar' => $this->toolbar,
            default => null,
        };
    }
}
