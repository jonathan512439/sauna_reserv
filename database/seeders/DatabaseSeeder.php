<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
{
    \App\Models\Reservation::create([
        'user_id' => 1, // Asume que este ID pertenece a un usuario existente
        'ambiente_id' => 1, // Asume que este ambiente existe
        'start_time' => now(),
        'end_time' => now()->addHour(),
        'status' => 'active',
    ]);
}

}
