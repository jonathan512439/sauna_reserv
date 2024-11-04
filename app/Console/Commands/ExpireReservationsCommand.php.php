<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ReservationController;

class ExpireReservationsCommand extends Command
{
    protected $signature = 'reservations:expire';
    protected $description = 'Actualizar reservas que han expirado';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $reservationController = new ReservationController();
        $reservationController->updateExpiredReservations();
        $this->info('Reservas expiradas actualizadas exitosamente.');
    }
}
