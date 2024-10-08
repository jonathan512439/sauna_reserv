<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Si no vas a usar las columnas created_at o updated_at
    public $timestamps = true;

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Si hay algún campo que deseas que sea "fillable" o protegidos de asignación masiva
    protected $fillable = ['type', 'data', 'read_at'];
}
