@extends('layouts.app')

@section('content')
<div class="container mt-5" style="margin-left: 4%">
    <h1>Editar Reservación</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <!-- Selección de ambiente -->
        <div class="form-group">
            <label for="ambiente_id">Ambiente</label>
            <select name="ambiente_id" id="ambiente_id" class="form-control" required>
                @foreach($ambientes as $ambiente)
                    <option value="{{ $ambiente->id }}" {{ $ambiente->id == $reservation->ambiente_id ? 'selected' : '' }}>
                        {{ $ambiente->name }} (Capacidad: {{ $ambiente->capacity }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Hora de Inicio -->
        <div class="form-group mt-3">
            <label for="start_time">Hora de Inicio (HH:MM)</label>
            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($reservation->start_time)->format('H:i')) }}" required>
        </div>

        <!-- Hora de Fin -->
        <div class="form-group mt-3">
            <label for="end_time">Hora de Fin (HH:MM)</label>
            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($reservation->end_time)->format('H:i')) }}" required>
        </div>

        <!-- Estado de la Reservación -->
        <div class="form-group mt-3">
            <label for="status">Estado de la Reservación</label>
            <select name="status" id="status" class="form-control" required>
                <option value="active" {{ $reservation->status == 'active' ? 'selected' : '' }}>Activa</option>
                <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Actualizar Reservación</button>
    </form>
</div>
@endsection
