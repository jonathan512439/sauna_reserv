<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EncargadoController;
use App\Http\Controllers\AmbienteController;
use App\Http\Controllers\ContactController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Ruta para la página de inicio
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Ruta para la página de contacto
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {

    // Rutas del Administrador
    Route::middleware(['auth'])->group(function () {
        // Definir la ruta para el dashboard del administrador
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Ruta para que el administrador o encargado marque la reserva como pagada
        Route::post('/admin/reservations/{id}/mark-as-paid', [ReservationController::class, 'markAsPaid'])->name('admin.reservations.markAsPaid');

        // Ruta para gestionar reservas pendientes y activarlas
        Route::get('/reservas/pendientes', [ReservationController::class, 'showPendingReservations'])->name('reservations.pending');
        Route::post('/reservas/{id}/activate', [ReservationController::class, 'activate'])->name('reservations.activate');

        // Ruta para que el administrador vea las reservas y sus estados
        Route::get('/admin/reservations', [ReservationController::class, 'manageReservations'])->name('admin.reservations');

        // Ruta para cancelar una reserva (solo administrador y encargado)
        Route::delete('/reservas/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

        // Gestión de usuarios
        Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
        Route::post('/admin/users/{user}/assign-role', [AdminController::class, 'assignRole'])->name('admin.assignRole');
        Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');

        // Gestión de ambientes
        Route::get('/admin/ambientes', [AdminController::class, 'manageAmbientes'])->name('admin.ambientes');
        Route::get('/admin/ambientes/{id}/edit', [AmbienteController::class, 'edit'])->name('admin.ambientes.edit');
        Route::patch('/admin/ambientes/{id}', [AmbienteController::class, 'update'])->name('admin.ambientes.update');
        Route::delete('/admin/ambientes/{id}', [AmbienteController::class, 'destroy'])->name('admin.ambientes.destroy');


    });

    // Estado del sistema
    Route::post('/admin/toggle-system-status', [AdminController::class, 'toggleSystemStatus'])->name('admin.toggleSystemStatus');

    // Rutas del Encargado
    Route::middleware(['auth'])->group(function () {
        Route::get('/encargado/dashboard', [EncargadoController::class, 'dashboard'])->name('encargado.dashboard');
        Route::resource('ambientes', AmbienteController::class);

        // Solo el encargado o el administrador pueden marcar como pagada una reserva o activarla
        Route::post('/reservas/{id}/mark-as-paid', [ReservationController::class, 'markAsPaid'])->name('reservations.markAsPaid');
        Route::post('/reservas/{id}/activate', [ReservationController::class, 'activate'])->name('reservations.activate');
    });

    // Rutas generales para usuarios regulares
    Route::get('/dashboard', [AmbienteController::class, 'dashboard'])->name('dashboard');

    // Rutas para reservas (solo para usuarios)
    Route::get('/reservas/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::get('/reservas/index', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservas/available-hours/{ambiente}', [ReservationController::class, 'getAvailableHours'])->name('reservations.available_hours');

    Route::post('/reservas', [ReservationController::class, 'store'])->name('reservations.store');

    // Editar y actualizar reservas
    Route::delete('/reservas/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::get('/reservas/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::patch('/reservas/{id}', [ReservationController::class, 'update'])->name('reservations.update');

    // Actualización de estado de reservas
    Route::get('/reservas/update-status', [ReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
    Route::get('/notify-upcoming-reservations', [ReservationController::class, 'notifyUpcomingReservations']);

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de autenticación
require __DIR__.'/auth.php';
