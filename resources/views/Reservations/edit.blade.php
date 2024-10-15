@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Editar Ambiente</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ambientes.update', $ambiente->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $ambiente->name) }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="capacity">Capacidad</label>
            <input type="number" class="form-control" id="capacity" name="capacity" value="{{ old('capacity', $ambiente->capacity) }}" min="1" required>
        </div>

        <div class="form-group mt-3">
            <label for="available_from">Disponible Desde (HH:MM)</label>
            <input type="time" class="form-control" id="available_from" name="available_from" value="{{ old('available_from', $ambiente->available_from->format('H:i')) }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="available_until">Disponible Hasta (HH:MM)</label>
            <input type="time" class="form-control" id="available_until" name="available_until" value="{{ old('available_until', $ambiente->available_until->format('H:i')) }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="description">Descripción (Opcional)</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $ambiente->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Actualizar Ambiente</button>
    </form>
</div>
@endsection
