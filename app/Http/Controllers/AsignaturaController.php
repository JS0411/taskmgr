<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Docente;
use App\Models\Asignatura;
use Illuminate\Support\Facades\Auth;

class AsignaturaController extends Controller
{
    public function create() {
        if (Auth::user()->tipo == 'docente') {
            return view('asignatura.create');
        } else {
            abort(503);
        }
    }

    public function store(array $input)
    {
        Validator::make($input, [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:255'],
            'carrera_id' => ['required', 'integer'],
            'docente_id' => ['required', 'integer'],
        ])->validate();

        $asignatura = Docente::where('user_id', $input['docente'])->get()->Asignatura::create([
            'nombre' => $input['nombre'],
            'descripcion' => $input['descripcion'],
            'carrera_id' => $input['carrera'],
            'estado' => 'En Curso',
        ]);

        $asignatura->carrera()->attach('carrera_id');
        
        return $asignatura->save();

    }
    
    public function show($id)
    {
        $asignatura = Asignatura::find($id);
        $user = Auth::user();

        $datos = [
            'nombre' => $asignatura->nombre,
            'nombre_docente' => $asignatura->docente()->nombre,
            'descripcion' => $asignatura->descripcion,
            'estado' => $asignatura->estado,
            'evaluaciones' => $asignatura->evaluaciones,
            'estudiantes' => $asignatura->estudiantes,
        ];

        return view('asignatura.show', compact('datos'));

    }

    public function edit($id, $input, $mode)
    {
        $asignatura = Asignatura::find($id);
        $user = Auth::user();

        $datos = [
            'nombre' => $asignatura->nombre,
            'nombre_docente' => $asignatura->docente()->nombre,
            'descripcion' => $asignatura->descripcion,
            'estado' => $asignatura->estado,
            'evaluaciones' => $asignatura->evaluaciones,
            'estudiantes' => $asignatura->estudiantes,
        ];

        return view('asignatura.show', compact('datos'));

    }


}
