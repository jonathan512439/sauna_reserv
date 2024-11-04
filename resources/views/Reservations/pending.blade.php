@extends('layouts.app')

@section('content')
<div class="container mt-5" style="margin-left: 50px">
    <h1 class="mb-4">Reservas Pendientes</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($pendingReservations->isEmpty())
        <p>No hay reservas pendientes.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Ambiente</th>
                    <th>Cliente</th>
                    <th>Hora de Inicio</th>
                    <th>Hora de Fin</th>
                    <th>Método de Pago</th>
                    <th>Estado de Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingReservations as $reservation)
                    <tr>
                        <td>{{ $reservation->ambiente->name }}</td>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}</td>
                        <td>{{ ucfirst($reservation->payment_method) }}</td>
                        <td>{{ ucfirst($reservation->payment_status) }}</td>
                        <td>
                            @if($reservation->payment_status == 'paid')
                                <form action="{{ route('reservations.confirm', $reservation->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Confirmar</button>
                                </form>
                            @else
                                <span class="text-danger">Pago pendiente</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
