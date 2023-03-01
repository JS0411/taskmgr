<?php

namespace App\Actions\Fortify;

use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\User;
use App\Models\Carrera;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'cedula' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'tipo' => ['required', 'string', 'max:255'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $usuario = User::create([
            'nombre' => $input['nombre'],
            'apellido' => $input['apellido'],
            'cedula' => $input['cedula'],
            'email' => $input['email'],
            'tipo' => $input['tipo'],
            'password' => Hash::make($input['password']),
        ]);

        if ($input['tipo'] =='estudiante'){
            $estudiante = Estudiante::create([
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'cedula' => $usuario->cedula,
                'email' => $usuario->email,
                'materias_cursadas' => 0,
                'materias_aprobadas' => 0,
                'materias_reprobadas' => 0,
                'promedio' => 0.00,
                'user_id' => $usuario->id,
                'carrera_id' => Carrera::find(1)->id,
            ]);
            $estudiante->carrera()->associate(Carrera::Find(1));
            $estudiante->save();
        } else if ($input['tipo'] =='docente') {
            $docente = Docente::create([
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'cedula' => $usuario->cedula,
                'email' => $usuario->email,
                'user_id' => $usuario->id,
            ]); 
            $docente->save();
        } else {
            abort(403);
        }

        return $usuario;
    }
}
