<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Docente extends User
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nombre',
        'apellido',
        'cedula',
        'tipo',
        'user_id',
    ];

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class);
    }

}
