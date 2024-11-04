@extends('layouts.app')

@section('content')
<div class="container mt-5" style="margin-left: 5%">
    <h1>Crear Nuevo Ambiente</h1>

    {{-- Ventana de errores --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Ventana de éxito (si es necesario) --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('ambientes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="capacity">Capacidad</label>
            <input type="number" class="form-control" id="capacity" name="capacity" value="{{ old('capacity') }}" min="1" required>
        </div>

        <div class="form-group mt-3">
            <label for="available_from">Disponible Desde (HH:MM)</label>
            <input type="time" class="form-control" id="available_from" name="available_from" value="{{ old('available_from') }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="available_until">Disponible Hasta (HH:MM)</label>
            <input type="time" class="form-control" id="available_until" name="available_until" value="{{ old('available_until') }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="price">Precio (Bs.)</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" min="0" step="0.01" required>
        </div>

        <div class="form-group mt-3">
            <label for="description">Descripción (Opcional)</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
        </div>

        <!-- Campo para subir imagen -->
        <div class="form-group mt-3">
            <label for="image">Subir imagen del ambiente</label>
            <input type="file" class="form-control" name="image" id="image">
        </div>

        <button type="submit" class="btn btn-primary mt-4">Crear Ambiente</button>
    </form>
</div>
@endsection
