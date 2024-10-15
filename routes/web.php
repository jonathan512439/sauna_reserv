<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EncargadoController;
use App\Http\Controllers\AmbienteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Ruta para la página de inicio
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {

    // Rutas del Administrador
    Route::middleware(['auth'])->group(function () {
        // Definir la ruta para el dashboard del administrador
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Ruta para gestionar usuarios
        Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
        Route::post('/admin/users/{user}/assign-role', [AdminController::class, 'assignRole'])->name('admin.assignRole');

        // Rutas para gestionar ambientes como administrador
        Route::get('/admin/ambientes', [AdminController::class, 'manageAmbientes'])->name('admin.ambientes');
        Route::get('/admin/ambientes/{id}/edit', [AmbienteController::class, 'edit'])->name('admin.ambientes.edit');
        Route::patch('/admin/ambientes/{id}', [AmbienteController::class, 'update'])->name('admin.ambientes.update');
        Route::delete('/admin/ambientes/{id}', [AmbienteController::class, 'destroy'])->name('admin.ambientes.destroy');
    });

    // Ruta para cambiar el estado del sistema
    Route::post('/admin/toggle-system-status', [AdminController::class, 'toggleSystemStatus'])->name('admin.toggleSystemStatus');

    // Rutas del Encargado
    Route::middleware(['auth'])->group(function () {
        Route::get('/encargado/dashboard', [EncargadoController::class, 'dashboard'])->name('encargado.dashboard');
        Route::resource('ambientes', AmbienteController::class);
    });

    // Rutas generales para usuarios regulares
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas para reservas
    Route::get('/reservas', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservas', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservas/create', [ReservationController::class, 'create'])->name('reservations.create');

    Route::get('/reservas/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::patch('/reservas/{id}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservas/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::post('/reservas/{id}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');

    // Rutas adicionales para estado de reservas
    Route::get('/reservas/update-status', [ReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
    Route::get('/notify-upcoming-reservations', [ReservationController::class, 'notifyUpcomingReservations']);

    // Rutas para perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas para autenticación (login, logout, etc.)
require __DIR__.'/auth.php';
