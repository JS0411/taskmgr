<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\ActividadController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
Route::get('/asignatura/create', [AsignaturaController::class, 'create'])->name('asignatura.create');
Route::post('/asignatura', [AsignaturaController::class, 'store'])->name('asignatura.store');
Route::get('/asignatura/{id}', [AsignaturaController::class, 'show'])->name('asignatura.show');
Route::get('/asignatura/{id}/edit', [AsignaturaController::class, 'edit'])->name('asignatura.edit');
Route::put('/asignatura/{id}', [AsignaturaController::class, 'update'])->name('asignatura.update');

Route::get('/actividad/create', [ActividadController::class, 'create'])->name('actividad.create');
Route::post('/actividad', [ActividadController::class, 'store'])->name('actividad.store');
Route::get('/actividad/{id}', [ActividadController::class, 'show'])->name('actividad.show');
Route::get('/actividad/{id}/edit', [ActividadController::class, 'edit'])->name('actividad.edit');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});
