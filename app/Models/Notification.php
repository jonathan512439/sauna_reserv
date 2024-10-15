<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory, Notifiable;

    // Si no vas a usar las columnas created_at o updated_at
    public $timestamps = true;

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function toMail($notifiable)
{
    throw new \Exception('Notificación enviada.');
}

    // Si hay algún campo que deseas que sea "fillable" o protegidos de asignación masiva
    protected $fillable = ['type', 'data', 'read_at'];
}
