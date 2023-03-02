<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'sede',
        'nombre',
    ];

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class);
    }
}
