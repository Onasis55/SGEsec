<?php

use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\CicloEscolarController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\HorarioControllerOld;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SancionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AutenticacionRoles;
use App\Http\Middleware\EstudianteMiddleware;
use App\Http\Middleware\ProfesorMiddleware;
use App\Http\Middleware\TutorMiddleware;
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
    AdminMiddleware::class,
])->prefix('administrador')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('DashboardAdministrador');
    })->name('dashboard.administrador')->middleware(AutenticacionRoles::class);

    Route::resource('roles', RolController::class);
    Route::resource('users', UserController::class);

    Route::post('users/store-profesor', [UserController::class, 'storeProfesor'])->name('users.storeProfesor');
    Route::post('users/store-estudiante', [UserController::class, 'storeEstudiante'])->name('users.storeEstudiante');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    EstudianteMiddleware::class,
])->prefix('estudiante')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('DashboardEstudiante');
    })->name('dashboard.estudiante')->middleware(AutenticacionRoles::class);
    Route::get('/horario', [EstudianteController::class, 'VerHorario'])
        ->name('estudiante.horario');

    Route::get('/ver-horario', function () {
        return Inertia::render('VerHorario');
    })->name('estudiante.ver-horario');

    Route::get('/horario-completo', [EstudianteController::class, 'verHorarioCompleto'])->name('estudiante.horarioCompleto');

    Route::get('/ver-horario-completo', function () {
        return Inertia::render('VerHorarioCompleto');
    })->name('estudiante.verHorarioCompleto');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    TutorMiddleware::class,
])->prefix('tutor')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('DashboardTutor');
    })->name('dashboard.tutor')->middleware(AutenticacionRoles::class);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    ProfesorMiddleware::class,
])->prefix('profesor')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('DashboardProfesor');
    })->name('dashboard.profesor')->middleware(AutenticacionRoles::class);
});

Route::resource('materias', MateriaController::class);
Route::resource('ciclosescolares', CicloEscolarController::class);
Route::resource('calificaciones', CalificacionController::class);
Route::resource('reportes', ReporteController::class);
Route::resource('sanciones', SancionController::class);
Route::resource('profesores', ProfesorController::class);
Route::resource('estudiantes', EstudianteController::class);

Route::resource('grupos', GrupoController::class);

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/horario/nuevo', [HorarioController::class, 'nuevo'])->name('horario.nuevo');
        Route::post('/horario/cargar/materias/{nivel}',[HorarioController::class,'cargarMaterias']);
        Route::post('/horario/store', [HorarioController::class, 'store'])->name('horario.store');
        Route::post('/horario/guardar-completo', [HorarioController::class, 'guardarHorarioCompleto'])->name('horario.guardarCompleto');
    });

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard')->middleware(AutenticacionRoles::class);
