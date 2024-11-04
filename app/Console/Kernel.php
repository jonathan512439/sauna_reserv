<?php

namespace App\Console;

use App\Http\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Auth;

class Kernel extends ConsoleKernel
{
    /**
     * Define el array de comandos de la aplicación.
     *
     * @var array
     */
    protected $commands = [
        // Aquí van tus comandos personalizados si es necesario
    ];

    /**
     * Define las tareas programadas.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Ejecuta el envío de recordatorios cada minuto
        $schedule->call(function () {
            $reservationController = new ReservationController();
            $reservationController->notifyUpcomingReservations();
            app(\App\Http\Controllers\ReservationController::class)->updateExpiredReservations(); // Llama al método que envía recordatorios
        })->everyMinute();
        $schedule->command('reservations:expire')->hourly();

    }

    /**
     * Aquí es donde registramos todos los middlewares de ruta personalizados
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'role' => \App\Http\Middleware\CheckRole::class, // Registrar aquí CheckRole
    ];

    /**
     * Registra los comandos personalizados para la aplicación.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
