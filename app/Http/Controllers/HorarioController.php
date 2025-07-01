<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class HorarioController extends Controller
{
    public function nuevo(){
        $niveles = Materia::query()
            ->distinct()
            ->select('nivel')
            ->get()
            ->pluck('nivel');

        return Inertia::render('Horario', [
            'niveles' => $niveles,
        ]);
    }

    public function cargarMaterias($nivel){
        $materias = Materia::where('nivel','=',$nivel)->get()->toArray();
        if(count($materias) === 0) {
            throw new \Exception('No se han encontrado registros para material');
        }

        $week = [
            [], // lunes,
            [], // martes
            [], // miercoles
            [], // jueves
            [] // viernes
        ];


        $getMateria = function () use ($materias) {
            $materiaIndex = rand(0, count($materias) - 1);
            $materia = &$materias[$materiaIndex];
            if(!isset($materias['contador']))
                $materia['contador'] = 0; // si no existe la llave se crea
            $materia['contador']++;
            return $materia;
        };

        $materiasPorDia = 4;

        for ($i = 0; $i < count($materias); $i++) {
            $materias[$i]['hora_inicial'] = 0; // 8 am
            $materias[$i]['hora_final'] = 0; // 8 am
            $materias[$i]['contador'] = 0;
            $materias[$i] = (object) $materias[$i];
        }

        for($dia = 0; $dia < 5; $dia++){
            $contadorPorDia = 0;
            while($contadorPorDia < $materiasPorDia){
                // tenemos que filtrar las material no hallan asiganod mas de 3 veces
                $materiasFiltradas = array_filter($materias, function ($m) {
                    return $m->contador < 3;
                });

                if(count($materiasFiltradas) === 0){
                    break; // sin mas materias disponibles
                }
                $indices = array_keys($materiasFiltradas);
                $materiaIndex = $indices[array_rand($indices)];
                $materia = $materiasFiltradas[$materiaIndex];
                $week[$dia][] = $materia;
                $materia->contador++;
                $contadorPorDia++;
            }
        }


        // NOTA: el prfoesor debe salir random de la relacion profesor con materia
        //


        for($i = 0; $i < count($week); $i++){
            $date = Carbon::createFromTime(8);
            for($j = 0; $j < count($week[$i]); $j++){
                $week[$i][$j] = (array) $week[$i][$j];
                $materia = &$week[$i][$j];
                $materia['hora_inicial'] = $date->format('H:i');
                $date->addMinutes(90);
                $materia['hora_final'] = $date->format('H:i');
                $profesoresPorMateria = DB::table('materias_users')
                    ->where('materia_id','=',$materia['id'])
                    ->get();
                if(count($profesoresPorMateria) === 0){
                    continue;
                }
                $usuarioProfesorMateria = $profesoresPorMateria->random();

                $profesor = User::query()
                    ->where('id','=',$usuarioProfesorMateria->user_id)
                    ->firstOrFail();
                $materia['profesor'] = $profesor->name; //aqui el nombre del profe random
                $materia['profesor_id'] = $profesor->id; // aqui va su id del radom
            }
        }



        return response()->json([
            'materias' => $week,
        ]);
    }
}
