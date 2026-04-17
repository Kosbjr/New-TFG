<?php
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Autenticacion\LoginController;
use App\Http\Controllers\Autenticacion\RegistroController;
use Illuminate\Support\Facades\Route;

/*
Web publica
*/
Route::get('/', function () {
    return view('landing');
});

/*
autenticacion
*/
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegistroController::class, 'show'])->name('register');
Route::post('/register', [RegistroController::class, 'store']);

/*
tripas app
*/
Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/mensajes', function () {
        return view('mensajes.index');
    })->name('mensajes');

    Route::get('/citas', function () {
        return view('citas.index');
    })->name('citas');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
