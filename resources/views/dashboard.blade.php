@extends('layouts.app')

@section('content')
    <section id="dashboard" class="dashboard section" style="margin-left: 5%">
        <div class="container section-title" style="margin-left: 100px;">
            <h2>Bienvenido al Sistema de Reservas</h2>
            <p>Gestiona y consulta la disponibilidad de los ambientes en nuestro sauna.</p>
        </div>
            <!-- Galería de Ambientes -->
<section id="gallery" class="gallery section">
    <div class="container section-title text-center">
        <h2>Galería de Ambientes</h2>
        <p>Explora los diferentes ambientes disponibles en nuestro sauna.</p>
    </div>

    <div class="container">
        <div class="row gy-4">
            @foreach($ambientes as $ambiente)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100">
                        <div class="image-container" style="height: 250px; overflow: hidden; border-radius: 10px;">
                            <img src="{{ asset('storage/' . $ambiente->image_path) }}" class="img-fluid zoom-image" style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $ambiente->name }}">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $ambiente->name }}</h5>
                            <p class="card-text flex-grow-1">{{ $ambiente->description }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

        <!-- Opciones adicionales para el usuario -->
        <section id="user-options" class="py-5 text-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('reservations.create') }}" class="btn btn-primary btn-lg">
                            Crear una Reserva
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('reservations.index') }}" class="btn btn-primary btn-lg">
                            Ver Reservas
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
