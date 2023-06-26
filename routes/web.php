<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\AdminController;
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
Route::get('/admin', function () {
    return Inertia::render('Admin');
})->middleware(['auth', 'verified'])->name('admin');

/**
 * Rutas para tareas
 */
Route::post('/creartarea', [TareasController::class, 'crearTarea']);
Route::post('/consultartareas', [TareasController::class, 'consultarTareas']);
Route::put('/actualizartarea', [TareasController::class, 'actualizar']);
Route::delete('/eliminartarea/{id}', [TareasController::class, 'eliminar']);
Route::post('/ordentareas', [TareasController::class, 'ordenarTareas']);

/**
 * Rutas de admin
 */
Route::get('/usuariologgeado', [AdminController::class, 'usuarioLoggeado']);
Route::get('/listausuarios', [AdminController::class, 'listaUsuarios']);
Route::post('/editarusuario', [AdminController::class, 'editarUsuarios']);
Route::post('/eliminarusuario', [AdminController::class, 'eliminarUsuario']);

require __DIR__.'/auth.php';
