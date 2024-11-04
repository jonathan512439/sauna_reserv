<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Agrega los campos permitidos para la asignación masiva
    protected $fillable = [
        'user_id',
        'ambiente_id',
        'start_time',
        'end_time',
        'status',
        'payment_method',
        'payment_status',
        'payment_amount',
    ];


   // App\Models\Reservation.php
// App\Models\Reservation.php
public function user()
{
    return $this->belongsTo(User::class);
}

public function ambiente()
{
    return $this->belongsTo(Ambiente::class);
}


}
