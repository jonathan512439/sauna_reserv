<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        // Verifica si el usuario está autenticado
        /*if (Auth::check()) {
            // Llama al método hasRole() en el usuario autenticado
            if (Auth::user()->hasRole($role)) {
                return $next($request); // Permite el acceso si el rol es correcto
            } else {
                return redirect('/')->with('error', 'No tienes los permisos necesarios.'); // Redirige si no tiene el rol adecuado
            }
        }*/

        // Si no está autenticado, redirige al login
        return redirect('/login')->with('error', 'Por favor, inicia sesión primero.');
    }
}
