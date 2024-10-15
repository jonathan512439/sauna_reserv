@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Crear Nueva Reserva</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf

        <!-- Selección de ambiente -->
        <div class="form-group">
            <label for="ambiente_id">Ambiente</label>
            <select name="ambiente_id" id="ambiente_id" class="form-control">
                @foreach($ambientes as $ambiente)
                    <option value="{{ $ambiente->id }}">{{ $ambiente->name }} (Disponible de {{ $ambiente->available_from }} a {{ $ambiente->available_until }})</option>
                @endforeach
            </select>
        </div>

        <!-- Selección de la hora de inicio -->
        <div class="form-group">
            <label for="start_time">Hora de Inicio</label>
            <input type="time" name="start_time" id="start_time" class="form-control" min="08:00" max="20:00" step="3600" required>
            <small class="form-text text-muted">Selecciona una hora entre las 08:00 y las 20:00. Las reservas son por intervalos de una hora.</small>
        </div>

        <button type="submit" class="btn btn-primary">Hacer Reserva</button>
    </form>
</div>

<script>
    // Escucha cambios en el selector de ambiente para ajustar el rango de horas
    document.getElementById('ambiente_id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const availableFrom = selectedOption.getAttribute('data-available-from');
        const availableUntil = selectedOption.getAttribute('data-available-until');
        const startTimeInput = document.getElementById('start_time');

        // Ajustar el rango del input de hora
        startTimeInput.setAttribute('min', availableFrom);
        startTimeInput.setAttribute('max', availableUntil);
    });
</script>
@endsection
