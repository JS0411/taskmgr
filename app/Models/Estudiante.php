<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estudiante extends User
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'nombre',
        'apellido',
        'cedula',
        'materias_cursadas',
        'materias_aprobadas',
        'materias_reprobadas',
        'promedio',
        'user_id',
        'carrera_id',
    ];

    public function carrera() 
    {
        return $this->belongsTo(Carrera::class);
    }

    public function actividades()
    {
        return $this->belongsToMany(Actividad::class)->withPivot('puntuacion', 'entregado');
    }
    
    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class)->withPivot('puntuacion', 'resultado');
    }
}
