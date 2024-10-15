@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Panel de Usuario</div>
                <ul class="list-group list-group-flush">
                    <!-- <li class="list-group-item">
                        <a href="{{ route('profile.edit') }}" class="text-dark">Editar Perfil</a>
                    </li> -->
                    <li class="list-group-item">
                        <a href="{{ route('reservations.index') }}" class="text-dark">Mis Reservas</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('reservations.create') }}" class="text-dark">Hacer Nueva Reserva</a> <!-- Enlace añadido -->
                    </li>
                    <li class="list-group-item">
                        <a href="{{ route('logout') }}" class="text-dark"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Cerrar Sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Bienvenido, {{ Auth::user()->name }}</div>
                <div class="card-body">
                    <p>Aquí podrás gestionar tus reservas y actualizar tu perfil.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
