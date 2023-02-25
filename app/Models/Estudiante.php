<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends User
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
        'materias_cursadas',
        'materias_aprobadas',
        'materias_reprobadas',
        'promedio',
        'user_id',
    ];

    public function carrera() 
    {
        return $this->belongsTo(Carrera::class);
    }

    public function actividades()
    {
        return $this->hasMany(Actividad::class);
    }
    
    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class);
    }
}
$table->foreignId('id_estudiante')->constrained('users')->onDelete('cascade');
            $table->integer('materias_cursadas');
            $table->integer('materias_aprobadas');
            $table->integer('materias_reprobadas');
            $table->float('promedio', 3, 2);