<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Asignatura extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'carrera_id',
        'docente_id',
        'descripcion',
        'estado',
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
        return $this->belongsToMany(Estudiante::class)->withPivot('puntuacion', 'resultado');
    }
}
