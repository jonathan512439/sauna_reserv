<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class MailController extends Controller
{
    /**
     * Send a test email.
     */
    public function sendTestEmail()
    {
        // Define the email address to send the test email
        $to_email = 'pomacarlos434@gmail.com';  // Aquí pones el email del destinatario

        // Envía el correo usando la clase TestMail
        Mail::to($to_email)->send(new TestMail());

        return response()->json(['message' => 'Correo de prueba enviado correctamente.']);
    }
}
