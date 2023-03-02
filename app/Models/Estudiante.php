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

    public function cierreAsignatura($puntuacion)
    {
        if ($this->materias_cursadas == 0){
            $this->materias_cursadas = 0;
            $this->materias_aprobadas = 0;
            $this->materias_reprobadas = 0;
        }
        if ($puntuacion < 6) {
            $this->materias_reprobadas = $this->materias_reprobadas + 1;
        } else {
            $this->materias_aprobadas = $this->materias_aprobadas + 1;
        }
        $this->materias_cursadas = $this->materias_cursadas + 1;
        return true;
    }

    public function calcularPromedio($puntuacion)
    {
        $notas = $this->asignaturas()->where('estado', 'Finalizado')->wherePivot('estudiante_id', $this->id)->get();
        $total = 0;
        $contador = 0;
        foreach ($notas as $nota) {
           $total = $total + $nota->pivot->puntuacion;
           $contador = $contador + 1;
        }
        $this->promedio = ($total + $puntuacion) / ($contador + 1); 
        return true;
    }
}
