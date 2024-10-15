@php
    use Illuminate\Support\Facades\Route;
@endphp
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Gestión de Ambientes</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('ambientes.create') }}" class="btn btn-primary mb-4">Crear Nuevo Ambiente</a>

    @if($ambientes->isEmpty())
        <p>No hay ambientes disponibles.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Capacidad</th>
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
                        <td>{{ $ambiente->available_from }}</td>
                        <td>{{ $ambiente->available_until }}</td>
                        <td>
                            <a href="{{ route('ambientes.edit', $ambiente->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('ambientes.destroy', $ambiente->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
