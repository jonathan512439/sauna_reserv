@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Editar Ambiente</h1>

    <form action="{{ route('ambientes.update', $ambiente->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="name">Nombre</label>
            <!-- Este campo mantiene el valor actual del nombre -->
            <input type="text" class="form-control" id="name" name="name" value="{{ $ambiente->name }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="capacity">Capacidad</label>
            <!-- Campo en blanco al editar -->
            <input type="number" class="form-control" id="capacity" name="capacity" placeholder="Ingresa la capacidad" min="1" required>
        </div>

        <div class="form-group mt-3">
            <label for="available_from">Disponible Desde (HH:MM)</label>
            <!-- Campo en blanco al editar -->
            <input type="time" class="form-control" id="available_from" name="available_from" required>
        </div>

        <div class="form-group mt-3">
            <label for="available_until">Disponible Hasta (HH:MM)</label>
            <!-- Campo en blanco al editar -->
            <input type="time" class="form-control" id="available_until" name="available_until" required>
        </div>

        <div class="form-group mt-3">
            <label for="description">Descripción (Opcional)</label>
            <!-- Campo en blanco al editar -->
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Agrega una descripción">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Actualizar Ambiente</button>
    </form>
</div>
@endsection
