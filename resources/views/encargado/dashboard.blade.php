@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center mb-4">Panel de Control - Encargado</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header">
                    Gestión de Ambientes
                </div>
                <div class="card-body">
                    <p class="card-text">Añade, edita y elimina ambientes disponibles para los usuarios.</p>
                    <a href="{{ route('ambientes.index') }}" class="btn btn-primary">Gestionar Ambientes</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header">
                    Ver Reservas
                </div>
                <div class="card-body">
                    <p class="card-text">Consulta las reservas realizadas por los usuarios.</p>
                    <a href="{{ route('reservations.pending') }}" class="btn btn-primary">Ver Reservas</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
