<?php

namespace App\Grid;

use App\Models\User;
use Illuminate\Http\Request;

class UserGrid extends Grid
{
    protected string $modelClass = User::class;

    protected string $title = 'Usuarios';
    protected string $resource = 'users';

    protected string $page = 'Usuario';

    protected array $visibleColumns = [
        'users.cuenta',
        'users.name',
        'users.apellido_paterno',
        'users.apellido_materno',
        'users.curp',
        'rols.clave',
    ];

    protected array $joinColumns = [];

    protected function mounted()
    {
        $this->addLeftJoin(
            'rols',
            'users.rol_id',
            '=',
            'rols.id',
            ['rols.clave']
        );
    }

    /**
     * Devuelve el nombre del componente Vue para editar usuarios
     */
    protected function getEditFormPage(): ?string
    {
        return 'UsuarioEdit'; // Cambiado para usar el componente de edición
    }

    /**
     * Aplica filtro de búsqueda al query
     */
    protected function applySearchFilter($query, ?string $search)
    {
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%$search%")
                    ->orWhere('users.apellido_paterno', 'like', "%$search%")
                    ->orWhere('users.apellido_materno', 'like', "%$search%")
                    ->orWhere('users.curp', 'like', "%$search%")
                    ->orWhere('rols.clave', 'like', "%$search%");
            });
        }
    }

    /**
     * Obtiene los datos para el grid con filtros y paginación
     */
    public function getData(Request $request)
    {
        $search = $request->input('search');

        $query = $this->modelClass::query();

        // Aplica los joins definidos
        foreach ($this->joins as $join) {
            if ($join['type'] === 'left') {
                $query->leftJoin($join['table'], $join['first'], $join['operator'], $join['second']);
            } elseif ($join['type'] === 'inner') {
                $query->join($join['table'], $join['first'], $join['operator'], $join['second']);
            }
            // Puedes agregar otros tipos de join si los usas
        }

        // Aplica filtro de búsqueda
        $this->applySearchFilter($query, $search);

        // Selecciona columnas visibles y de joins
        $columns = $this->visibleColumns;
        if (!empty($this->joinColumns)) {
            $columns = array_merge($columns, $this->joinColumns);
        }

        $query->select($columns);

        // Puedes agregar orden, paginación, etc.
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
