<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use App\Models\Ambiente;

class AdminController extends Controller
{
    public function __construct()
    {
        // Protege todas las rutas del controlador con autenticación
        $this->middleware('auth');
    }

    public function dashboard()
    {
        // Verifica si existe un registro en la tabla settings
        $setting = Setting::first();

        if (!$setting) {
            // Si no existe, crea un registro con valores predeterminados
            $setting = Setting::create([
                'is_system_open' => true, // El sistema está abierto por defecto
            ]);
        }

        // Recupera el estado del sistema
        $systemStatus = $setting->is_system_open;

        return view('admin.dashboard', compact('systemStatus'));
    }

    // Método para cambiar el estado del sistema
    public function toggleSystemStatus()
    {
        $setting = Setting::first();

        if ($setting) {
            // Alterna el estado del sistema
            $setting->is_system_open = !$setting->is_system_open;
            $setting->save();
        }

        return redirect()->route('admin.dashboard')->with('success', 'El estado del sistema ha sido actualizado.');
    }

    // Método para gestionar usuarios
    public function manageUsers()
    {
        // Obtener todos los usuarios de la base de datos
        $users = User::all();

        // Pasar la variable $users a la vista
        return view('admin.users', compact('users'));
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,encargado,user', // Validar que el rol sea uno de los permitidos
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users')->with('success', 'Rol asignado con éxito.');
    }
    // Método para gestionar ambientes
    public function manageAmbientes()
    {
        // Obtener todos los ambientes de la base de datos
        $ambientes = Ambiente::all();

        // Pasar la variable $ambientes a la vista
        return view('admin.ambientes', compact('ambientes'));
    }
}
