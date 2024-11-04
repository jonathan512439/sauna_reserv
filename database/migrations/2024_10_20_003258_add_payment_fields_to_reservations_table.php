<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentFieldsToReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('status'); // Campo para guardar si se paga con tarjeta o QR
            $table->string('payment_status')->default('pending')->after('payment_method'); // pending, paid, etc.
            $table->decimal('payment_amount', 10, 2)->default(0)->after('payment_status'); // El monto total del pago
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('payment_method');
            $table->dropColumn('payment_status');
            $table->dropColumn('payment_amount');
        });
    }
}
