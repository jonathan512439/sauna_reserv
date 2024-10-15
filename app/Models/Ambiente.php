<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    use HasFactory;

    // Aquí está el array de $fillable correctamente definido
    protected $fillable = [
        'name',
        'capacity',
        'description',
        'available_from',
        'available_until',
        'is_active', // Si existe en la base de datos
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
