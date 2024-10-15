@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Tus Reservas</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($reservations->isEmpty())
        <p>No tienes reservas actuales.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Ambiente</th>
                    <th>Hora de Inicio</th>
                    <th>Hora de Fin</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->ambiente->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}</td>
                        <td>{{ ucfirst($reservation->status) }}</td>
                        <td>
                            @if($reservation->status == 'active')
                                <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
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
