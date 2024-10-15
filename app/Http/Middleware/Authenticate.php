<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    // Este método se ejecuta si el usuario no está autenticado
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login'); // Redirigir al login si no está autenticado
        }
    }
}
