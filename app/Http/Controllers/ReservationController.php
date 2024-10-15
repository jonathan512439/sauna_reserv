<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Ambiente;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Notifications\ReservationConfirmation;
use App\Notifications\ReservationReminder;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Método para mostrar las reservas del usuario autenticado
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors('Debes iniciar sesión para ver tus reservas.');
        }

        $reservations = $user->reservations;

        if ($reservations->isEmpty()) {
            return back()->with('error', 'No tienes reservas actuales.');
        }

        return view('reservations.index', compact('reservations'));
    }

     // ----------------------->   Crear una nueva reserva < --------------------------------------

      // Importamos el modelo para los ajustes del sistema

   public function store(Request $request)
   {
    // Verificar si el sistema está abierto
    $settings = Setting::first();
    if (!$settings->is_system_open) {
        return back()->withErrors('El sistema está cerrado temporalmente. No se pueden realizar reservas en este momento.');
    }

    // Validar el resto de la lógica como antes
    $userId = Auth::id();
    $request->validate([
        'start_time' => 'required|date_format:H:i',
        'ambiente_id' => 'required|exists:ambientes,id',
    ]);

    $ambiente = Ambiente::find($request->ambiente_id);
    $startTime = \Carbon\Carbon::today()->setTimeFromTimeString($request->start_time);
    $endTime = $startTime->copy()->addHour();

    // Verificar si el horario está disponible
    $availableFrom = \Carbon\Carbon::createFromTimeString($ambiente->available_from);
    $availableUntil = \Carbon\Carbon::createFromTimeString($ambiente->available_until);

    if ($startTime->lt($availableFrom) || $endTime->gt($availableUntil)) {
        return back()->withErrors('El horario seleccionado no está disponible para este ambiente.');
    }

    // Verificar si hay reservas solapadas
    $overlappingReservations = Reservation::where('ambiente_id', $request->ambiente_id)
        ->where(function ($query) use ($startTime, $endTime) {
            $query->whereBetween('start_time', [$startTime, $endTime])
                  ->orWhereBetween('end_time', [$startTime, $endTime]);
        })
        ->exists();

    if ($overlappingReservations) {
        return back()->withErrors('El ambiente ya está reservado en ese horario.');
    }

    // Crear la nueva reserva
    $reservation = Reservation::create([
        'user_id' => $userId,
        'ambiente_id' => $request->ambiente_id,
        'start_time' => $startTime,
        'end_time' => $endTime,
        'status' => 'active',
    ]);

    // Notificar al usuario
    Auth::user()->notify(new ReservationConfirmation($reservation));

    return redirect()->route('reservations.index')->with('success', 'Reserva creada con éxito.');
}


     // -------------------- Creacion de Reserava
     public function create()
{
    $ambientes = Ambiente::all(); // Obtener todos los ambientes disponibles
    return view('reservations.create', compact('ambientes')); // Vista de creación de reservas
}



    // ---------------------------------------------------------Método para editar una reserva
    public function edit($id)
    {
        $reservation = Reservation::find($id);

        // Verificar si la reserva pertenece al usuario autenticado
        if (!$reservation || $reservation->user_id != Auth::id()) {
            return redirect()->route('reservations.index')->withErrors('No tienes permiso para editar esta reserva.');
        }

        $ambientes = Ambiente::all(); // Obtener todos los ambientes

        return view('reservations.edit', compact('reservation', 'ambientes'));
    }

    // Método para actualizar una reserva
    public function update(Request $request, $id)
{
    // Validar que la hora esté entre 08:00 y 20:00 y que sea una hora exacta
    $request->validate([
        'start_time' => [
            'required',
            function ($attribute, $value, $fail) {
                $startTime = \Carbon\Carbon::createFromFormat('H:i', $value);

                // Verificar que la hora esté dentro del rango 08:00 - 20:00
                if ($startTime->hour < 8 || $startTime->hour >= 20) {
                    $fail('La hora de inicio debe estar entre las 8:00 AM y las 8:00 PM.');
                }

                // Verificar que sea una hora exacta (minutos deben ser 0)
                if ($startTime->minute != 0) {
                    $fail('La hora de inicio debe ser una hora exacta.');
                }
            },
        ],
        'ambiente_id' => 'required|exists:ambientes,id',
    ]);

    // Buscar la reserva
    $reservation = Reservation::findOrFail($id);

    // Obtener la fecha actual y combinarla con la hora seleccionada
    $startTime = \Carbon\Carbon::today()->setTimeFromTimeString($request->start_time);

    // Calcular la hora de fin automáticamente una hora después de la hora de inicio
    $endTime = $startTime->copy()->addHour();

    // Actualizar la reserva
    $reservation->update([
        'ambiente_id' => $request->ambiente_id,
        'start_time' => $startTime,
        'end_time' => $endTime,  // Hora de salida calculada automáticamente
    ]);

    return redirect()->route('reservations.index')->with('success', 'Reserva actualizada correctamente');
}

public function cancel($id)
{
    $reservation = Reservation::find($id);

    if (!$reservation || $reservation->user_id != Auth::id()) {
        return redirect()->route('reservations.index')->withErrors('No tienes permiso para cancelar esta reserva.');
    }

    if ($reservation->status != 'active') {
        return redirect()->route('reservations.index')->withErrors('Solo puedes cancelar reservas activas.');
    }

    $reservation->status = 'cancelled';
    $reservation->save();

    return redirect()->route('reservations.index')->with('success', 'Reserva cancelada con éxito.');
}

public function updateStatus()
{
    $now = now();
    $reservations = Reservation::where('status', 'active')
        ->where('end_time', '<', $now)
        ->get();

    foreach ($reservations as $reservation) {
        $reservation->status = 'completed';
        $reservation->save();
    }

    return redirect()->route('reservations.index')->with('success', 'Estados de las reservas actualizados.');
}
public function updateReservationStatus()
{
    // Obtenemos todas las reservas activas cuyo tiempo de finalización ya pasó
    $reservations = Reservation::where('status', 'active')
        ->where('end_time', '<', now())
        ->get();

    foreach ($reservations as $reservation) {
        // Cambiamos el estado a 'completed'
        $reservation->update([
            'status' => 'completed'
        ]);
    }

    Log::info("Se actualizaron las reservas completadas.");
}

    //Notificacion 15 minutos antes

    public function notifyUpcomingReservations()
    {
        // Seleccionar las reservas que comienzan en los próximos 15 minutos
        $reservations = Reservation::where('status', 'active')
            ->whereBetween('start_time', [now(), now()->addMinutes(15)])
            ->get();

        foreach ($reservations as $reservation) {
            $user = $reservation->user;
            $user->notify(new ReservationReminder($reservation)); // Enviar notificación
        }

        Log::info("Se enviaron recordatorios de reservas.");
    }
    // Método para cancelar una reserva
    public function destroy($id)
    {
        $reservation = Reservation::find($id);

        // Verificar si la reserva pertenece al usuario autenticado
        if (!$reservation || $reservation->user_id != Auth::id()) {
            return redirect()->route('reservations.index')->withErrors('No tienes permiso para cancelar esta reserva.');
        }

        $reservation->delete(); // Eliminar la reserva

        return redirect()->route('reservations.index')->with('success', 'Reserva cancelada correctamente.');
    }
}
