<?php

namespace App\Http\Controllers;

use App\Models\HorarioItem;
use App\Models\Materia;
use App\Models\User;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HorarioController extends Controller
{
    public function nuevo()
    {
        $niveles = Materia::query()
            ->distinct()
            ->select('nivel')
            ->get()
            ->pluck('nivel');

        $grupos = Grupo::all();

        return Inertia::render('Horario', [
            'niveles' => $niveles,
            'grupos' => $grupos,
        ]);
    }

    public function cargarMaterias($nivel)
    {
        $materias = Materia::where('nivel', '=', $nivel)->get()->toArray();
        if (count($materias) === 0) {
            throw new \Exception('No se han encontrado registros para materia');
        }

        $week = [
            [], // lunes,
            [], // martes
            [], // miercoles
            [], // jueves
            []  // viernes
        ];

        $materiasPorDia = 4;

        for ($i = 0; $i < count($materias); $i++) {
            $materias[$i]['hora_inicial'] = 0;
            $materias[$i]['hora_final'] = 0;
            $materias[$i]['contador'] = 0;
            $materias[$i] = (object) $materias[$i];
        }

        for ($dia = 0; $dia < 5; $dia++) {
            $contadorPorDia = 0;
            while ($contadorPorDia < $materiasPorDia) {
                $materiasFiltradas = array_filter($materias, function ($m) {
                    return $m->contador < 3;
                });

                if (count($materiasFiltradas) === 0) {
                    break;
                }
                $indices = array_keys($materiasFiltradas);
                $materiaIndex = $indices[array_rand($indices)];
                $materia = $materiasFiltradas[$materiaIndex];
                $week[$dia][] = $materia;
                $materia->contador++;
                $contadorPorDia++;
            }
        }

        for ($i = 0; $i < count($week); $i++) {
            $date = Carbon::createFromTime(8);
            for ($j = 0; $j < count($week[$i]); $j++) {
                $week[$i][$j] = (array) $week[$i][$j];
                $materia = &$week[$i][$j];
                $materia['hora_inicial'] = $date->format('H:i');
                $date->addMinutes(90);
                $materia['hora_final'] = $date->format('H:i');
                $profesoresPorMateria = DB::table('materias_users')
                    ->where('materia_id', '=', $materia['id'])
                    ->get();
                if (count($profesoresPorMateria) === 0) {
                    continue;
                }
                $usuarioProfesorMateria = $profesoresPorMateria->random();

                $profesor = User::query()
                    ->where('id', '=', $usuarioProfesorMateria->user_id)
                    ->firstOrFail();
                $materia['profesor'] = $profesor->name;
                $materia['profesor_id'] = $profesor->id;
            }
        }

        return response()->json([
            'materias' => $week,
        ]);
    }

    public function guardarHorarioCompleto(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'materias' => 'required|array',
            'materias.*.id' => 'required|exists:materias,id',
            'materias.*.hora_ini' => 'required|date_format:H:i',
            'materias.*.hora_fin' => 'required|date_format:H:i|after:materias.*.hora_ini',
            'materias.*.dia_semana' => 'required|integer|between:0,4',
        ]);

        $grupo = Grupo::findOrFail($request->grupo_id);

        $grupo->horarioItems()->delete();

        foreach ($request->materias as $materia) {
            HorarioItem::create([
                'grupo_id' => $grupo->id,
                'dia_semana' => $materia['dia_semana'],
                'materia_id' => $materia['id'],
                'hora_ini' => $materia['hora_ini'],
                'hora_fin' => $materia['hora_fin'],
            ]);
        }

        return response()->json(['message' => 'Horario completo guardado correctamente']);
    }

    public function verHorarioAlumnoTutor(Request $request)
    {
        $user = $request->user();

        $estudiantes = $user->estudiantesTutorados()->with('grupo.horarioItems.materia')->get();

        if ($estudiantes->isEmpty()) {
            return response()->json(['error' => 'No se encontraron estudiantes asignados'], 404);
        }

        $estudiante = $estudiantes->first();

        if (!$estudiante->grupo) {
            return response()->json(['error' => 'El estudiante no tiene grupo asignado'], 404);
        }

        $horarioItems = $estudiante->grupo->horarioItems;

        if ($horarioItems->isEmpty()) {
            return response()->json(['error' => 'No hay un horario asignado para el estudiante'], 404);
        }

        return response()->json([
            'estudiante' => [
                'id' => $estudiante->id,
                'nombre' => $estudiante->user->name ?? 'Estudiante',
            ],
            'horarioItems' => $horarioItems,
        ]);
    }
}
