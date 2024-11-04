@php
    use Illuminate\Support\Facades\Route;
@endphp
@extends('layouts.app')

@section('content')
<div class="container mt-5" style="margin-left: 4%;">
    <h1 class="mb-4 text-center">Administración de Usuarios</h1>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover shadow-lg">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Rol Actual</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge
                                @if($user->role == 'admin') bg-success
                                @elseif($user->role == 'encargado') bg-warning
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.assignRole', $user) }}" method="POST" class="d-inline-block">
                                @csrf
                                <div class="me-2 d-inline-block">
                                    <select name="role" class="form-select" required>
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Usuario</option>
                                        <option value="encargado" {{ $user->role == 'encargado' ? 'selected' : '' }}>Encargado</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Asignar Rol</button>
                            </form>
                            <!-- Botón de eliminar -->
                            <button type="button" class="btn btn-danger delete-btn">Eliminar</button>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmación requerida</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas realizar esta acción?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmBtn">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
        let formToSubmit = null;

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                formToSubmit = this.closest('.delete-form');
                confirmModal.show();
            });
        });

        document.getElementById('confirmBtn').addEventListener('click', function () {
            if (formToSubmit) {
                formToSubmit.submit();
            }
        });
    });
</script>
@endsection
