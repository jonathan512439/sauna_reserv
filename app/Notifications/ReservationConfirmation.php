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
        return ['mail']; // Asegúrate de incluir 'database' si estás usando notificaciones en la base de datos
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Confirmación de Reserva')
            ->line('Tu reserva ha sido confirmada.')
            ->action('Ver Reserva', url('/reservas'))
            ->line('Gracias por utilizar nuestro sistema!');
    }

    /**
     * Almacenar notificación en la base de datos.
     */
    public function toArray($notifiable)
    {
        return [
            'reservation_id' => $this->reservation->id,
            'message' => 'Tu reserva ha sido confirmada',
        ];
    }
}
