@extends('layouts.app')

@section('content')
<div class="container mt-5" style="margin-left: 80px">
    <h1>Gestión de Reservas</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($reservations->isEmpty())
        <p>No hay reservas en este momento.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Ambiente</th>
                    <th>Hora de Inicio</th>
                    <th>Estado de Pago</th>
                    <th>Estado de Reserva</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    @if($reservation->status != 'cancelled')  <!-- Excluir las reservas canceladas -->
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
                                <span class="badge
                                    @if($reservation->status == 'pending') bg-warning
                                    @elseif($reservation->status == 'active') bg-success
                                    @elseif($reservation->status == 'completed') bg-secondary
                                    @endif">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>
                            <td>
                                @if($reservation->payment_status == 'pending' && $reservation->status != 'cancelled')
                                    <form action="{{ route('admin.reservations.markAsPaid', $reservation->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Aceptar Pago</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
