@php
    use Illuminate\Support\Facades\Route;
@endphp
@extends('layouts.app')

@section('content')
<div class="container mt-5" style="margin-left: 100px">
    <h1>Crear Nuevo Ambiente</h1>

    <form action="{{ route('ambientes.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group mt-3">
            <label for="capacity">Capacidad</label>
            <input type="number" class="form-control" id="capacity" name="capacity" min="1" required>
        </div>

        <div class="form-group mt-3">
            <label for="available_from">Disponible Desde (HH:MM)</label>
            <input type="time" class="form-control" id="available_from" name="available_from" required>
        </div>

        <div class="form-group mt-3">
            <label for="available_until">Disponible Hasta (HH:MM)</label>
            <input type="time" class="form-control" id="available_until" name="available_until" required>
        </div>
        <div class="form-group mt-3">
            <label for="description">Descripción (Opcional)</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
        </div>
           <!-- Campo para subir imagen -->
        <div class="form-group">
           <label for="image">Subir imagen del ambiente</label>
           <input type="file" class="form-control" name="image" id="image">
        </div>

        <button type="submit" class="btn btn-primary mt-4">Crear Ambiente</button>
    </form>
</div>
@endsection
