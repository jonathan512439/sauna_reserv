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
    { //Intermediario
        $this->middleware('auth');
    }

    // Método para mostrar las reservas del usuario autenticado
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors('Debes iniciar sesión para ver tus reservas.');
        }

        // Solo mostrar reservas con estado "activo" o "pendiente"
        $reservations = $user->reservations()->whereIn('status', ['active', 'pending', 'expired'])->get();

    return view('reservations.index', compact('reservations'));
    }


    // ----------------------->   Crear una nueva reserva < --------------------------------------
    public function store(Request $request)
    {
        // Verificar si el sistema está abierto
        $settings = Setting::first();
        if (!$settings->is_system_open) {
            return back()->withErrors('El sistema está cerrado temporalmente. No se pueden realizar reservas en este momento.');
        }

        // Validar los campos del formulario
        $request->validate([
            'ambiente_id' => 'required|exists:ambientes,id',
            'payment_method' => 'required|in:tarjeta,qr',
            'start_time' => 'required|date_format:H:i',
        ]);

        $userId = Auth::id();
        $ambiente = Ambiente::find($request->ambiente_id);
        $startTime = now()->setTimeFromTimeString($request->start_time); // Asignar la fecha actual con la hora de inicio
        $endTime = $startTime->copy()->addHour(); // Hora de fin es una hora después de la hora de inicio
        $paymentAmount = $ambiente->price;

        // Verificar disponibilidad del ambiente
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

        // Crear la nueva reserva con el estado de pago 'pending'
        $reservation = Reservation::create([
            'user_id' => $userId,
            'ambiente_id' => $request->ambiente_id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending', // La reserva empieza como "pending"
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending', // Estado de pago se establece en 'pending'
            'payment_amount' => $paymentAmount,
        ]);

        return redirect()->route('reservations.index')->with('success', 'Reserva creada, el pago está pendiente de confirmación.');
    }



private function processPayment($method, $amount)
{
    // Simulación: aceptar todos los pagos, excepto cuando el método de pago es 'qr' y el monto es mayor a 500
    if ($method === 'qr' && $amount > 500) {
        return false; // Fallar el pago con QR si el monto es mayor a 500
    }
    return true; // Todos los demás pagos se procesan correctamente
}

// Simular el pago con tarjeta de manera ficticia
protected function processFakeCardPayment($amount)
{
    // Aquí puedes agregar cualquier lógica de simulación. Por ejemplo:
    if ($amount > 0) {
        return 'paid'; // Pago exitoso
    }
    return 'failed'; // Falla en el pago
}

// Simular el pago con QR de manera ficticia
protected function processFakeQRPayment($amount)
{
    // Simulación ficticia para el pago por QR
    if ($amount > 0) {
        return 'paid'; // Pago exitoso
    }
    return 'failed'; // Falla en el pago
}

public function showPendingReservations()
{
    // Obtener las reservas que están en estado "pending"
    $pendingReservations = Reservation::where('status', 'pending')->get();

    return view('reservations.pending', compact('pendingReservations'));
}

// Función para confirmar una reserva
public function confirmReservation($id)
{
    // Buscar la reserva por ID
    $reservation = Reservation::find($id);

    // Verificar que la reserva exista y esté en estado "pending"
    if ($reservation && $reservation->status == 'pending') {
        $reservation->status = 'active'; // Cambiar el estado a "active"
        $reservation->save();

        return redirect()->route('reservations.pending')->with('success', 'Reserva confirmada exitosamente.');
        Auth::user()->notify(new ReservationConfirmation($reservation));
    }

    return redirect()->route('reservations.pending')->withErrors('No se pudo confirmar la reserva.');
}

 // Mostrar las reservas pendientes
public function pending()
{
    $reservations = Reservation::where('status', 'pending')->get();
    return view('reservations.manage', compact('reservations'));
}

// Marcar una reserva como pagada
public function markAsPaid($id)
{
    // Verificar si el usuario autenticado es administrador o encargado
    $user = Auth::user();

    if (!($user->role == 'admin' || $user->role == 'encargado')) {
        return redirect()->back()->withErrors('No tienes permiso para realizar esta acción.');
    }

    // Encontrar la reserva por ID
    $reservation = Reservation::findOrFail($id);

    // Verificar que el pago esté pendiente
    if ($reservation->payment_status != 'pending') {
        return redirect()->back()->withErrors('El pago ya ha sido procesado.');
    }

    // Actualizar el estado de pago y de la reserva
    $reservation->update([
        'payment_status' => 'paid',
        'status' => 'active', // Cambiar el estado de la reserva a "activo"
    ]);

    // Enviar la notificación de confirmación de la reserva
    $reservation->user->notify(new ReservationConfirmation($reservation));

    return redirect()->back()->with('success', 'El pago ha sido aceptado y la reserva está ahora activa.');
}




// Activar una reserva después de haber sido pagada
public function activate($id)
{
    $reservation = Reservation::findOrFail($id);

    if ($reservation->payment_status != 'paid') {
        return redirect()->back()->withErrors('No se puede confirmar una reserva sin que el pago esté completado.');
    }

    $reservation->status = 'active';
    $reservation->save();

    // Enviar notificación por correo
    $reservation->user->notify(new ReservationConfirmation($reservation));

    return redirect()->route('reservations.pending')->with('success', 'Reserva confirmada y activada.');
}

    // -------------------- Creación de Reserva
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
    // Buscar la reserva por ID
    $reservation = Reservation::find($id);

    // Verificar que la reserva existe
    if (!$reservation) {
        return redirect()->route('reservations.index')->withErrors('No se encontró la reserva.');
    }

    // Solo permitir cancelar reservas que estén pendientes o activas
    if ($reservation->status != 'pending' && $reservation->status != 'active') {
        return redirect()->route('reservations.index')->withErrors('Solo se pueden cancelar reservas pendientes o activas.');
    }

    // Cambiar el estado a 'cancelled'
    $reservation->status = 'cancelled';
    $reservation->save();

    return redirect()->route('reservations.index')->with('success', 'Reserva cancelada con éxito.');
}




    public function manageReservations()
    {
        // Obtener todas las reservas excepto las canceladas
        $reservations = Reservation::with('user', 'ambiente')->whereNotIn('status', ['cancelled'])->get();

        return view('admin.reservations', compact('reservations'));
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
    public function updateExpiredReservations()
{
    $now = now();

    // Actualizar reservas activas cuya hora de fin ya ha pasado
    $expiredReservations = Reservation::where('status', 'active')
        ->where('end_time', '<', $now)
        ->update(['status' => 'expired']); // Cambiar el estado a "expirado"

    if ($expiredReservations > 0) {
        Log::info("Se han actualizado $expiredReservations reservas a expiradas.");
    }

    return redirect()->route('reservations.index')->with('success', 'Reservas expiradas actualizadas.');
}



    // Notificación 15 minutos antes
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
    public function getAvailableHours($ambienteId)
{
    $ambiente = Ambiente::findOrFail($ambienteId);
    $reservedHours = Reservation::where('ambiente_id', $ambienteId)
        ->whereDate('start_time', now()->format('Y-m-d'))
        ->pluck('start_time')
        ->map(function ($time) {
            return \Carbon\Carbon::parse($time)->format('H:i');
        });

    $availableHours = collect();
    $start = \Carbon\Carbon::createFromTimeString($ambiente->available_from);
    $end = \Carbon\Carbon::createFromTimeString($ambiente->available_until);

    while ($start->lessThan($end)) {
        $hour = $start->format('H:i');
        if (!$reservedHours->contains($hour)) {
            $availableHours->push($hour);
        }
        $start->addHour();
    }

    return response()->json($availableHours);
}


    // Método para cancelar una reserva
    public function destroy($id)
{
    $reservation = Reservation::find($id);

    if (!$reservation || $reservation->user_id != Auth::id()) {
        return redirect()->route('reservations.index')->withErrors('No tienes permiso para cancelar esta reserva.');
    }

    if ($reservation->status == 'cancelled') {
        return redirect()->route('reservations.index')->withErrors('Esta reserva ya fue cancelada.');
    }

    $reservation->status = 'cancelled';
    $reservation->save();

    return redirect()->route('reservations.index')->with('success', 'Reserva cancelada correctamente.');
}

}
