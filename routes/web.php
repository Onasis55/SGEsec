<?php

use App\Http\Controllers\MateriasController;
use App\Http\Controllers\RolController;
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

    Route::middleware('')
        ->prefix('estudiante/')
        ->group(function (){

        });
    Route::resource('materias', MateriasController::class);
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard')->middleware(AutenticacionRoles::class);
});
