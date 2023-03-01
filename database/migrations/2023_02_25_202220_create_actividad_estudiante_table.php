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
        Schema::create('actividad_estudiante', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('actividad_id')->constrained('actividads')->onDelete('cascade');
            $table->foreignId('estudiante_id')->constrained('estudiantes')->onDelete('cascade');
            $table->integer('puntuacion')->default(0);
            $table->boolean('entregado')->default(0); // 1 = Entregado
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividad_estudiante');
    }
};
