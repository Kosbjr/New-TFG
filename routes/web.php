<?php

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Autenticacion\LoginController;
use App\Http\Controllers\Autenticacion\RegistroController;
use App\Http\Controllers\Citas\CitaController;
use App\Http\Controllers\Servicios\ServicioController;
use App\Http\Controllers\Centro\CentroController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mensajes\MensajeController;
use App\Http\Controllers\Admin\CategoriaController;
// Web pública
Route::get('/', function () {
    $categorias = \App\Models\Categoria::all();
    return view('landing', compact('categorias'));
});

// Autenticación
Route::get('/login',    [LoginController::class, 'show'])->name('login');
Route::post('/login',   [LoginController::class, 'login']);
Route::get('/register', [RegistroController::class, 'show'])->name('register');
Route::post('/register', [RegistroController::class, 'store']);

// App
Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/mensajes', function () {
        return view('mensajes.index');
    })->name('mensajes');
    Route::get('/centro/editar', [CentroController::class, 'edit'])->name('centros.editar');

    Route::put('/centro', [CentroController::class, 'update'])->name('centro.update');

    Route::delete('/centro/foto/{id}', [CentroController::class, 'eliminarFoto'])->name('centro.foto.eliminar');

    Route::post('/centro/categorias', [CentroController::class, 'updateCategorias'])->name('centro.categorias.update');

    // Servicios
    Route::get('/centro/servicios',         [ServicioController::class, 'index'])->name('servicios.index');
    Route::post('/centro/servicios',        [ServicioController::class, 'store'])->name('servicios.store');
    Route::delete('/centro/servicios/{id}', [ServicioController::class, 'destroy'])->name('servicios.destroy');

    // Horarios
    Route::post('/centro/horarios',         [ServicioController::class, 'storeHorario'])->name('horarios.store');
    Route::delete('/centro/horarios/{id}',  [ServicioController::class, 'destroyHorario'])->name('horarios.destroy');


    Route::get('/centro/{id}',              [CentroController::class, 'show'])->name('centro.show');

    // Citas
    Route::get('/citas',                    [CitaController::class, 'index'])->name('citas');
    Route::get('/centros/{id}/agendar',     [CitaController::class, 'create'])->name('citas.create');
    Route::post('/centros/{id}/agendar',    [CitaController::class, 'store'])->name('citas.store');
    Route::patch('/citas/{id}/estado',      [CitaController::class, 'updateEstado'])->name('citas.estado');

    // Mensajes
    Route::get('/mensajes',                              [MensajeController::class, 'index'])->name('mensajes');
    Route::get('/mensajes/{centroId}/{usuarioId}',       [MensajeController::class, 'chat'])->name('mensajes.chat');
});


// Panel admin (categoria)
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/categorias',          [CategoriaController::class, 'categorias'])->name('admin.categorias');
    Route::post('/categorias',         [CategoriaController::class, 'storeCategoria'])->name('admin.categorias.store');
    Route::delete('/categorias/{id}',  [CategoriaController::class, 'destroyCategoria'])->name('admin.categorias.destroy');
});

// El centro asigna sus categorías
Route::middleware('auth')->group(function () {
    Route::post('/centro/categorias',  [CentroController::class, 'updateCategorias'])->name('centro.categorias.update');
});
