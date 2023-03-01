<?php

namespace App\Http\Controllers;

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

    public function show() 
    {

    }
}
