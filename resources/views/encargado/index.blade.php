@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ambientes</h1>
    <a href="{{ route('ambientes.create') }}" class="btn btn-primary">Agregar Ambiente</a>
    <table class="table mt-3">
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
                        <a href="{{ route('ambientes.edit', $ambiente->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('ambientes.destroy', $ambiente->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
