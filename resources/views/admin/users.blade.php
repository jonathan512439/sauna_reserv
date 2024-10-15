@php
    use Illuminate\Support\Facades\Route;
@endphp
@extends('layouts.app')

@section('content')
<h1>Administración de Usuarios</h1>

<table class="table">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol Actual</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <form action="{{ route('admin.assignRole', $user) }}" method="POST">
                        @csrf
                        <select name="role" required>
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Usuario</option>
                            <option value="encargado" {{ $user->role == 'encargado' ? 'selected' : '' }}>Encargado</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Asignar Rol</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
