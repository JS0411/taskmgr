<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Docente;
use App\Models\Asignatura;
use App\Models\Actividad;
use App\Models\Estudiante;
use Illuminate\Support\Carbon;


class ActividadController extends Controller
{
    public function create(Request $request)
    {
        $datos = $request->id;
        if (Auth::user()->tipo == 'docente') {
            return view('actividad.create', compact('datos'));
        } else {
            abort(503);
        }
    }

    public function store(Request $request)
    {
        $asignatura = Asignatura::findOrFail($request->asignatura_id);
        $actividad = $asignatura->actividades()->create([
            'fecha_entrega' => $request->entrega,
            'descripcion' => $request->descripcion,
            'estado' => 'Pendiente',
            'modalidad' => $request->modalidad,
            'puntuacionMaxima' => $request->porcentaje,
        ]);

        $actividad->save();
        if (!$asignatura->estudiantes->isEmpty()) {
            $asignatura->estudiantes->each(function ($estudiante) use ($actividad) {
                $estudiante->actividades()->attach($actividad->id);
                $estudiante->save();
            });
        }

        $datos = [
            'id' => $actividad->id,
            'fecha_entrega' => $actividad->entrega(),
            'descripcion' => $actividad->descripcion,
            'estado' => $actividad->estado,
            'modalidad' => $actividad->modalidad,
            'puntuacionMaxima' => $actividad->puntuacionMaxima,
            'puntuacion' => -1,
            'estudiantes' => $actividad->estudiantes,
        ];
        
        return view('actividad.show', compact('datos'));
    }
    
    public function show($id)
    {
        $actividad = Actividad::find($id);
        $user = Auth::user();
        $estudiante_puntuacion = 0;

        if ($user->tipo == 'estudiante'){
            $estudiante_id = Estudiante::where('user_id', $user->id)->first()->id;
            if (!$actividad->estudiantes->isEmpty()){
                $estudiante_puntuacion = $actividad->estudiantes()->wherePivot('estudiante_id', $estudiante_id)->first()->pivot->puntuacion;
            }
        }

        $datos = [
            'id' => $actividad->id,
            'fecha_entrega' => $actividad->entrega(),
            'descripcion' => $actividad->descripcion,
            'estado' => $actividad->estado,
            'modalidad' => $actividad->modalidad,
            'puntuacionMaxima' => $actividad->puntuacionMaxima,
            'puntuacion' => $estudiante_puntuacion,
            'estudiantes' => $actividad->estudiantes,
        ];
        return view('actividad.show', compact('datos'));

    }
}
