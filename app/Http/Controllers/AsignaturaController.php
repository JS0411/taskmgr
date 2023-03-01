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
