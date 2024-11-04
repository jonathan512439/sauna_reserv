<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationConfirmation extends Notification
{
    use Queueable;

    public $reservation;

    /**
     * Create a new notification instance.
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail']; // Can include 'database' if you are storing notifications in the database as well
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Confirmación de Reserva - Sauna San Márquez')
            ->view('emails.reservation_confirmation', [ // Custom view for email
                'reservation' => $this->reservation,
                'notifiable' => $notifiable
            ]);
    }

    /**
     * Store notification in the database.
     */
    public function toArray($notifiable)
    {
        return [
            'reservation_id' => $this->reservation->id,
            'message' => 'Tu reserva ha sido confirmada',
        ];
    }
}
