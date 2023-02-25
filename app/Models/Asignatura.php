<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;

    protected $fillable = [
        'carrera_id',
        'docente_id',
        'descripcion',
    ];

    public function docente() 
    {
        return $this->belongsTo(Docente::class);
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function actividades()
    {
        return $this->hasMany(Actividad::class);
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class);
    }
}
