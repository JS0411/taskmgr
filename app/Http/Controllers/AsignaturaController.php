<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Support\Facades\Validator;
use App\Models\Docente;
use App\Models\Asignatura;
use App\Models\Carrera;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

function attachActividadesToEstudiantes($estudiantes, $actividades) {
    foreach ($estudiantes as $estudiante) {
        $objEstudiante = Estudiante::findOrFail($estudiante);
        foreach ($actividades as $actividad) {
            $objEstudiante->actividades()->attach($actividad->id);
        }
        $objEstudiante->save();
    }
}

class AsignaturaController extends Controller
{
    
    
    public function create() {
        if (Auth::user()->tipo == 'docente') {
            return view('asignatura.create');
        } else {
            abort(503);
        }
    }

    public function store(Request $request)
    {
        $requestArray = $request->all();

        Validator::make($requestArray, [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:255'],
            'carrera_id' => ['required', 'integer'],
            'docente_id' => ['required', 'integer'],
        ])->validate();

        $asignatura = Docente::where('user_id', $requestArray['docente_id'])->first()->asignaturas()->create([
            'nombre' => $requestArray['nombre'],
            'descripcion' => $requestArray['descripcion'],
            'carrera_id' => $requestArray['carrera_id'],
            'estado' => 'En Curso',
        ]);
        $asignatura->carrera()->associate(Carrera::Find($asignatura->carrera_id));
        $asignatura->save();

        $datos = [
            'id' => $asignatura->id,
            'nombre' => $asignatura->nombre,
            'nombre_docente' => $asignatura->docente->nombre,
            'descripcion' => $asignatura->descripcion,
            'estado' => $asignatura->estado,
            'actividades' => $asignatura->actividades,
            'estudiantes' => $asignatura->estudiantes,
        ];

        return view('asignatura.show', compact('datos'));

    }
    
    public function show($id)
    {
        $asignatura = Asignatura::find($id);
        $user = Auth::user();

        $datos = [
            'id' => $asignatura->id,
            'nombre' => $asignatura->nombre,
            'nombre_docente' => $asignatura->docente->nombre,
            'descripcion' => $asignatura->descripcion,
            'estado' => $asignatura->estado,
            'actividades' => $asignatura->actividades,
            'estudiantes' => $asignatura->estudiantes,
        ];

        return view('asignatura.show', compact('datos'));

    }

    public function edit(Request $request, $id)
    {
        $asignatura = Asignatura::find($id);
        $modo = $request->modo;
        $user = Auth::user();

        if ($user->tipo == 'docente') {
            $listado_estudiantes = '';
            if ($modo == "Invitar") {
                $listado_estudiantes = Estudiante::whereDoesntHave('asignaturas', function ($q) use ($id) {
                    $q->where('asignatura_id', $id);
                })->get();
            } 
            $datos = [
                'id' => $asignatura->id,
                'nombre' => $asignatura->nombre,
                'nombre_docente' => $asignatura->docente->nombre,
                'descripcion' => $asignatura->descripcion,
                'estado' => $asignatura->estado,
                'actividades' => $asignatura->actividades,
                'estudiantes' => $asignatura->estudiantes,
                'listado_estudiantes' => $listado_estudiantes,
                'modo' => $modo,
            ];
            return view('asignatura.edit', compact('datos'));
    
        } else {
            abort(503);
        }
    }

    public function update(Request $request, $id)
    {
        $asignatura = Asignatura::find($id);
        $modo = $request->modo;
        $user = Auth::user();
        if ($user->tipo == 'docente') {            
            if ($modo == "Invitar") {
                $asignatura->estudiantes()->syncWithoutDetaching($request->estudiantes_invitados);
                $actividades = $asignatura->actividades;
                attachActividadesToEstudiantes($request->estudiantes_invitados, $actividades);
            } else if($modo == "Cerrar") {
                $asignatura->update(['estado' => 'Finalizado']);
                if (!$asignatura->estudiantes->isEmpty() && !$asignatura->actividades->isEmpty() ){
                    $estudiantes = $asignatura->estudiantes;
                    $actividades = $asignatura->actividades->pluck('id');
                    foreach ($estudiantes as $estudiante) {
                        $idEstudiante = $estudiante->id;
                        $nota = 0;
                        $puntuaciones = DB::table('actividad_estudiante')
                        ->join('actividads', 'actividad_estudiante.actividad_id', '=', 'actividads.id')
                        ->where('actividad_estudiante.estudiante_id', $estudiante->id)
                        ->whereIn('actividads.id', $actividades)
                        ->pluck('puntuacion', 'actividad_id');
                        $nota = $puntuaciones->sum()/$puntuaciones->count();
                        $estudiante->asignaturas()->updateExistingPivot($id, [
                            'puntuacion' => $nota,
                            'resultado' => ($nota < 6) ? 0 : 1, 
                        ]);
                        $estudiante->calcularPromedio($nota);
                        $estudiante->cierreAsignatura($nota);
                        $estudiante->save();
                        $asignatura->save();
                    }
                    $asignatura->save();
                }
            } else {
                abort(503);
            }
            $datos = [
                'id' => $asignatura->id,
                'nombre' => $asignatura->nombre,
                'nombre_docente' => $asignatura->docente->nombre,
                'descripcion' => $asignatura->descripcion,
                'estado' => $asignatura->estado,
                'actividades' => $asignatura->actividades,
                'estudiantes' => $asignatura->estudiantes,
                'modo' => $modo,
            ];
            return view('asignatura.show', compact('datos'));
    
        } else {
            abort(503);
        }
    }

    


}
