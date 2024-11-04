<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Validar los campos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Enviar el correo
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'messageContent' => $request->message,
        ];

        Mail::send('emails.contact', $data, function($message) use ($request) {
            $message->to('info@example.com', 'Soporte')
                    ->subject($request->subject);
        });

        // Redirigir con mensaje de éxito
        return back()->with('success', 'Tu mensaje ha sido enviado con éxito.');
    }
}
