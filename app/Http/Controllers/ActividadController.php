<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Docente;
use App\Models\Asignatura;
use App\Models\Actividad;


class ActividadController extends Controller
{
    public function create(array $input)
    {
        Validator::make($input, [
            'fecha_entrega' => ['required', 'timestamp', 'max:255'],
            'descripcion' => ['required', 'string', 'max:255'],
            'modalidad' => ['required', 'integer'],
            'puntuacionMaxima' => ['required', 'integer'],
            'asignatura_id' => ['required', 'integer'],
        ])->validate();

        $asignatura = Asignatura::FindOrFail($input['asignatura_id']);

        $actividad = $asignatura->Actividad::create([
            'fecha_entrega' => $input['fecha_entrega'],
            'descripcion' => $input['descripcion'],
            'estado' => 'Pendiente',
            'modalidad' => $input['modalidad'],
            'puntuacionMaxima' => $input['puntuacionMaxima'],
        ]);

        $actividad->save();

        if (!$asignatura->estudiantes()->isEmpty()) {
            $asignatura->estudiantes->each(function ($estudiante) {
                $estudiante->actividades()->attach($actividad);
                $estudiante->save();
            });
        }
        
        return $asignatura->save();

    }
    
    public function show($id)
    {
        $actividad = Actividad::find($id);
        $user = Auth::user();

        $datos = [
            'fecha_entrega' => $actividad->fecha_entrega,
            'descripcion' => $actividad->descripcion,
            'estado' => $actividad->estado,
            'modalidad' => $actividad->modalidad,
            'puntuacionMaxima' => $actividad->puntuacionMaxima,
            'puntuacion' => ($user->tipo == 'estudiante') ? $actividad->estudiantes->pivot->puntuacion : -1,
            'estudiantes' => $actividad->estudiantes,
        ];

        return view('asignatura.show', compact('datos'));

    }
}
