@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Gestión de Ambientes</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-12 text-center">
            <a href="{{ route('ambientes.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Crear Nuevo Ambiente
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if($ambientes->isEmpty())
                <p class="text-center">No hay ambientes disponibles.</p>
            @else
                <table class="table table-dark table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Capacidad</th>
                            <th>Descripción</th>
                            <th>Disponible Desde</th>
                            <th>Disponible Hasta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ambientes as $ambiente)
                            <tr>
                                <td>{{ $ambiente->name }}</td>
                                <td>{{ $ambiente->capacity }}</td>
                                <td>{{ $ambiente->description }}</td>
                                <td>{{ $ambiente->available_from }}</td>
                                <td>{{ $ambiente->available_until }}</td>
                                <td>
                                    <a href="{{ route('ambientes.edit', $ambiente->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>

                                    <form action="{{ route('ambientes.destroy', $ambiente->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Estás seguro de que deseas eliminar este ambiente?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
