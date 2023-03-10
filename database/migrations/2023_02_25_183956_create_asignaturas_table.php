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
        Schema::create('asignaturas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('carrera_id')->constrained('carreras')->onDelete('cascade');
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('estado');
            $table->foreignId('docente_id')->constrained('docentes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaturas');
    }
};
