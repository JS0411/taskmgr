<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asignatura_estudiante', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('asignatura_id')->constrained('asignaturas')->onDelete('cascade');
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->integer('puntuacion')->default(0);
            $table->boolean('resultado')->default(0); //1 = Aprobado
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignatura_estudiante');
    }
};
