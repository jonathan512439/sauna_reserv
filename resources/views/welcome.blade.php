@extends('layouts.app')

@section('content')

<section class="py-5 text-center" style="position: relative; background-image: url('{{ asset('images/fondo_sauna.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed; height: 100vh;">

    <!-- Logo  -->
    <div class="logo-container">
        <a href="{{ route('login') }}">
            <img src="{{ asset('images/logo_sauna.png') }}" alt="Logo del Sauna" class="logo">
        </a>
    </div>

    <div class="container px-5" style="background-color: rgba(255, 255, 255, 0.8); padding: 40px; border-radius: 15px; max-width: 700px;">
        <h2 class="fw-bolder mb-4 display-4" style="color: #333;">Una Experiencia de Relajación Inolvidable</h2>
        <p class="lead fs-3" style="color: #555;">
            En el Sauna "San Márquez", te ofrecemos un ambiente relajante y acogedor, diseñado para proporcionar paz y bienestar.
            Nuestros espacios están equipados con saunas finlandesas, baños de vapor y áreas de descanso, todo pensado para brindarte
            la mejor experiencia posible. ¡Relájate, disfruta y renueva tu cuerpo y mente en un entorno de tranquilidad!
        </p>
    </div>
</section>

<!-- Galería de Ambientes del Sauna -->
<section class="py-5 bg-light text-center">
    <div class="container px-5">
        <h2 class="fw-bolder mb-5">Nuestros Ambientes</h2>
        <div class="row gx-5">
            <!-- Ambiente 1 -->
            <div class="col-lg-4 col-md-6 mb-5">
                <div class="image-container">
                    <a href="{{ route('login') }}">
                        <img src="{{ asset('images/sauna_1.jpg') }}" class="img-fluid zoom-image img-equal" alt="Sauna finlandesa">
                    </a>
                </div>
                <h3 class="h5 mt-3">Sauna Finlandesa</h3>
                <p class="text-muted">Disfruta del calor seco que revitaliza el cuerpo.</p>
            </div>
            <!-- Ambiente 2 -->
            <div class="col-lg-4 col-md-6 mb-5">
                <div class="image-container">
                    <a href="{{ route('login') }}">
                        <img src="{{ asset('images/sauna_2.jpg') }}" class="img-fluid zoom-image img-equal" alt="Baño de Vapor">
                    </a>
                </div>
                <h3 class="h5 mt-3">Baño de Vapor</h3>
                <p class="text-muted">Relájate en un ambiente húmedo que purifica tu piel.</p>
            </div>
            <!-- Ambiente 3 -->
            <div class="col-lg-4 col-md-6 mb-5">
                <div class="image-container">
                    <a href="{{ route('login') }}">
                        <img src="{{ asset('images/sauna_3.jpg') }}" class="img-fluid zoom-image img-equal" alt="Área de Descanso">
                    </a>
                </div>
                <h3 class="h5 mt-3">Área de Descanso</h3>
                <p class="text-muted">Relájate entre sesiones en nuestras cómodas áreas de descanso.</p>
            </div>
        </div>
    </div>
</section>
@endsection

<!-- Estilos CSS personalizados -->
<style>
    /* Logo en la esquina superior izquierda */
    .logo-container {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 1000;
    }
    .logo {
        width: 120px;
        height: auto;
        cursor: pointer;
    }

    /* Imagen de fondo y recuadro */
    .hero-image {
        position: absolute;
        display: flex;
        align-items: flex-start;
        justify-content: flex-start;
        padding: 20px;
    }

    /* Efecto de zoom en las imágenes */
    .image-container {
        position: relative;
        overflow: hidden;
    }

    .zoom-image {
        transition: transform 0.5s ease;
        cursor: pointer;
    }

    .zoom-image:hover {
        transform: scale(1.1);
    }

    /* Ajuste de tamaño uniforme para todas las imágenes */
    .img-equal {
        height: 250px; /* Ajusta el tamaño para que todas las imágenes tengan la misma altura */
        object-fit: cover;
    }
</style>
