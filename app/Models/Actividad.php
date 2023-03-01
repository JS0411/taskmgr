<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha_entrega',
        'descripcion',
        'modalidad',
        'puntuacionMaxima',
        'asignatura_id',
        'estado',
    ];

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class)->withPivot('puntuacion', 'entregado');
    }
}