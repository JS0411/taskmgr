<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
Carbon::setLocale('es');

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

    public function entrega()
    {
        $fecha = Carbon::parse($this->fecha_entrega);
        if ((Carbon::Now()->diff($fecha, false)->format("%r%a") > 0)){
            $diff = Carbon::parse($this->fecha_entrega)->diffForHumans(Carbon::Now());
            return "Para entregar en {$diff}";
        } else {
            return "Pendiente por evaluar";
        }
    }
}