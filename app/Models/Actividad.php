<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha_entrega',
        'description',
        'modalidad',
        'puntuacionMaxima',
        'asignatura_id',
    ];

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class);
    }
}