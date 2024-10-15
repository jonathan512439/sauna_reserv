<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->foreignId('notifiable_id')->index(); // El ID del usuario que recibe la notificación
                $table->string('notifiable_type');           // Generalmente, "App\Models\User"
                $table->string('type');                      // La clase de notificación (e.g., 'App\Notifications\ReservationConfirmation')
                $table->text('data');                        // Los datos de la notificación (en formato JSON)
                $table->timestamp('read_at')->nullable();    // Si ha sido leída
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
