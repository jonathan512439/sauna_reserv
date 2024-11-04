@extends('layouts.app')

@section('content')
<div class="container mt-5" style="margin-left: 5%">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center mb-4">Panel de Control - Administrador</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card text-center bg-dark text-light">
                <div class="card-header">
                    <i class="bi bi-people-fill"></i> Gestión de Usuarios
                </div>
                <div class="card-body">
                    <p class="card-text">Asigna roles a usuarios y supervisa su actividad.</p>
                    <a href="{{ route('admin.users') }}" class="btn btn-primary">Gestionar Usuarios</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center bg-dark text-light">
                <div class="card-header">
                    <i class="bi bi-building"></i> Gestión de Ambientes
                </div>
                <div class="card-body">
                    <p class="card-text">Añadir, editar o eliminar ambientes disponibles.</p>
                    <a href="{{ route('admin.ambientes') }}" class="btn btn-primary">Gestionar Ambientes</a>
                </div>
            </div>
        </div>
         <!-- Nueva sección para gestión de reservas -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card text-center bg-dark text-light">
                <div class="card-header">
                    <i class="bi bi-card-list"></i> Gestión de Reservas
                </div>
                <div class="card-body">
                    <p class="card-text">Revisa y gestiona todas las reservas y sus estados.</p>
                    <a href="{{ route('admin.reservations') }}" class="btn btn-primary">Gestionar Reservas</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-5" style="padding: 20px" >
            <div class="card text-center bg-dark text-light">
                <div class="card-header">
                    <i class="bi bi-power"></i> Estado del Sistema
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Estado actual del sistema: <strong>{{ $systemStatus ? 'Abierto' : 'Cerrado' }}</strong>
                    </p>
                    <form action="{{ route('admin.toggleSystemStatus') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-secondary">
                            {{ $systemStatus ? 'Cerrar Sistema' : 'Abrir Sistema' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
