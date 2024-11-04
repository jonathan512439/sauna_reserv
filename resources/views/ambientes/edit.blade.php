@extends('layouts.app')

@section('content')
<div class="container mt-5" style="margin-left: 4%">
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

    <form action="{{ route('ambientes.update', $ambiente->id) }}" method="POST" enctype="multipart/form-data">
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
            <input type="time" class="form-control" id="available_from" name="available_from" value="{{ old('available_from', $ambiente->available_from) }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="available_until">Disponible Hasta (HH:MM)</label>
            <input type="time" class="form-control" id="available_until" name="available_until" value="{{ old('available_until', $ambiente->available_until) }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="description">Descripción (Opcional)</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $ambiente->description) }}</textarea>
        </div>

        <!-- Mostrar la imagen existente si hay -->
        @if($ambiente->image_path)
            <div class="form-group">
                <label>Imagen Actual:</label><br>
                <img src="{{ asset('storage/' . $ambiente->image_path) }}" alt="Imagen del ambiente" style="max-width: 150px; margin-bottom: 15px;">
            </div>
        @endif

        <!-- Campo para subir una nueva imagen -->
        <div class="form-group">
            <label for="image">Cambiar Imagen del Ambiente</label>
            <input type="file" class="form-control" name="image" id="image">
        </div>

        <!-- Campo para el precio del ambiente -->
        <div class="form-group mt-3">
            <label for="price">Precio del Ambiente (Bs.)</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $ambiente->price) }}" step="0.01" required>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Actualizar Ambiente</button>
    </form>
</div>
@endsection
