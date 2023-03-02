<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Docente;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $ahora = Carbon::now();
        $unaSemana = Carbon::now()->addWeek();

        if ($user->tipo == 'estudiante') {
            $estudiante = Estudiante::where('user_id',$user->id)->first();
            $datos = [
                'nombre' => $estudiante->nombre,
                'apellido' => $estudiante->apellido,
                'cedula' => $estudiante->cedula,
                'asignaturas' => $estudiante->asignaturas()->where('estado', 'En Curso')->get(),
                'actividades' => $estudiante->actividades()->whereBetween('fecha_entrega', [$ahora, $unaSemana])->get(),
            ];
        } else {
            $docente = Docente::where('user_id',$user->id)->first();
            $datos = [
                'nombre' => $docente->nombre,
                'apellido' => $docente->apellido,
                'cedula' => $docente->cedula,
                'asignaturas' => $docente->asignaturas()->where('estado', 'En Curso')->get(),
            ];
        }
        return view('user.index', compact('datos'));

    }

    public function show($id) 
    {
        $user = Auth::user();
        Carrera::find(1);
        if ($user->tipo == "estudiante" && $user->id == $id){
            $estudiante = Estudiante::where('user_id', $id)->first();
            $datos = [
                'id' => $id,
                'carrera' => Carrera::find(1)->nombre,
                'sede' => Carrera::find(1)->sede,
                'promedio' => $estudiante->promedio,
                'materias_reprobadas' => $estudiante->asignaturas()->wherePivot('estudiante_id', $estudiante->id)->wherePivot('resultado', 0)->get(),
                'materias_aprobadas' => $estudiante->asignaturas()->wherePivot('estudiante_id', $estudiante->id)->wherePivot('resultado', 1)->get(),
                'materias_cursadas' => $estudiante->materiasCursadas,
            ];
            return view('user.show', compact('datos'));
        } else {
            abort(503);
        }
    }
}
