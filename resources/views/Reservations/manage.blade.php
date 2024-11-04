@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Reservas Pendientes</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($reservations->isEmpty())
        <p>No hay reservas pendientes.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Ambiente</th>
                    <th>Hora de Inicio</th>
                    <th>Estado de Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ $reservation->ambiente->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}</td>
                        <td>
                            @if($reservation->payment_status == 'paid')
                                <span class="badge bg-success">Pagado</span>
                            @else
                                <span class="badge bg-warning">Pendiente</span>
                            @endif
                        </td>
                        <td>
                            @if($reservation->payment_status == 'pending')
                                <form action="{{ route('reservations.markAsPaid', $reservation->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Marcar como Pagado</button>
                                </form>
                            @endif
                            @if($reservation->payment_status == 'paid' && $reservation->status == 'pending')
                                <form action="{{ route('reservations.activate', $reservation->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Activar Reserva</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
