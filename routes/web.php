<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\TareasController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('users/{id}', function ($id) {

});


/**
 * Rutas para proyectos
 */
Route::post('/crearproyecto', [ProyectosController::class, 'crear']);
Route::get('/consultarproyecto', [ProyectosController::class, 'consultar']);
Route::delete('/eliminarproyecto/{id}', [ProyectosController::class, 'eliminar']);
Route::get('/proyecto', function () {
    return Inertia::render('Proyecto');
})->middleware(['auth', 'verified'])->name('proyecto');

/**
 * Rutas para tareas
 */
Route::post('/creartarea', [TareasController::class, 'crearTarea']);
Route::post('/consultartareas', [TareasController::class, 'consultarTareas']);
Route::put('/actualizartarea', [TareasController::class, 'actualizar']);

require __DIR__.'/auth.php';
