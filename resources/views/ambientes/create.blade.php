@php
    use Illuminate\Support\Facades\Route;
@endphp
@extends('layouts.app')

@section('content')
<div class="container mt-5">
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

        <button type="submit" class="btn btn-primary mt-4">Crear Ambiente</button>
    </form>
</div>
@endsection
