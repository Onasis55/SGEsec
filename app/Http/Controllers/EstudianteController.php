<?php

namespace App\Http\Controllers;

use App\Grid\Grid;
use App\Models\Estudiante;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;


class EstudianteController extends Grid
{

    protected string $modelClass = Estudiante::class;

    protected string $title = 'Estudiantes';

    protected string $page = 'Estudiantes';

    protected string $resource = 'estudiantes';
    protected function mounted()
    {
        $this->addJoin(
            'users',
            'users.id',
            '=',
            'estudiantes.id_usuario',
            [
                'users.name', 'users.rol_id'
            ]
        );

        $this->setWhereClause(function (Builder $builder){
            /** @var Estudiante $estudiantes */
            $rolEstudiante = Rol::query()
                ->where('clave','=','estudiante')
                ->firstOrFail();
            $builder->where('users.rol_id', $rolEstudiante->id);
        });
    }
    protected function defaultActions(){}

    public function verHorario(Request $request)
    {
        $user = $request->user();

        $estudiante = $user->estudiante()->with('grupo.horario.materia')->first();

        if (!$estudiante || !$estudiante->grupo) {
            return response()->json(['error' => 'No tienes un grupo asignado'], 404);
        }

        $horario = $estudiante->grupo->horario;

        return response()->json([
            'horario' => $horario,
            'materia' => $horario ? $horario->materia : null,
        ]);
    }

    public function verHorarioCompleto(Request $request)
    {
        $user = $request->user();

        $estudiante = $user->estudiante()->with('grupo.horarioItems.materia')->first();

        if (!$estudiante || !$estudiante->grupo) {
            return response()->json(['error' => 'No tienes un grupo asignado'], 404);
        }

        $horarioItems = $estudiante->grupo->horarioItems;

        return response()->json([
            'horarioItems' => $horarioItems,
        ]);
    }
}
