<?php

use App\Http\Controllers\HorarioController;
use App\Http\Controllers\MateriasController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AutenticacionRoles;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::redirect('/', '/login');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('roles', RolController::class);
    Route::resource('users', UserController::class);

    Route::post('users/store-profesor', [UserController::class, 'storeProfesor'])->name('users.storeProfesor');
    Route::post('users/store-estudiante', [UserController::class, 'storeEstudiante'])->name('users.storeEstudiante');

    Route::middleware('')
        ->prefix('estudiante/')
        ->group(function (){

        });
    Route::resource('materias', MateriasController::class);
    //Route::resource('ciclosescolares',\App\Http\Controllers\CicloEscolarController::class);
    Route::resource('horarios', HorarioController::class);
    Route::resource('calificaciones',\App\Http\Controllers\CalificacionController::class);
    Route::resource('reportes',\App\Http\Controllers\ReporteController::class);
    Route::resource('sanciones',\App\Http\Controllers\SancionController::class);
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard')->middleware(AutenticacionRoles::class);
});
