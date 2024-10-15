<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * Los campos que pueden ser rellenados.
     *
     * @var array<int, string>
     */
    protected $fillable = ['is_system_open'];
}
