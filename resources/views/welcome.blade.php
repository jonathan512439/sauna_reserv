@extends('layouts.app')

@section('content')

<!-- Sección de bienvenida con imagen de fondo y degradado -->
<section class="py-5 text-center" style="position: relative; background-image: url('{{ asset('images/fondo_sauna.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed; height: 100vh; display: flex; align-items: center; justify-content: center;">

    <!-- Degradado que cubre toda la imagen -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.1)); z-index: 1;"></div>

    <!-- Contenido del texto -->
    <div class="container" style="position: relative; z-index: 2; padding: 60px; border-radius: 15px; max-width: 800px;">
        <h2 class="fw-bolder mb-4 display-4" style="color: #fff; text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);">Una Experiencia de Relajación Inolvidable</h2>
        <p class="lead fs-3" style="color: #f0f0f0; text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.7);">
            En el Sauna "San Márquez", te ofrecemos un ambiente relajante y acogedor, diseñado para proporcionar paz y bienestar.
            Nuestros espacios están equipados con saunas finlandesas, baños de vapor y áreas de descanso, todo pensado para brindarte
            la mejor experiencia posible. ¡Relájate, disfruta y renueva tu cuerpo y mente en un entorno de tranquilidad!
        </p>
    </div>
</section>

<!-- Galería de Ambientes del Sauna -->
<section class="py-5 bg-light text-center" style="margin-left: 5%">
    <div class="container px-5">
        <h2 class="fw-bolder mb-5">Nuestros Ambientes</h2>
        <div class="row gx-5">
            <!-- Ambiente 1 -->
            <div class="col-lg-4 col-md-6 mb-5">
                <div class="image-container" style="height: 100%; overflow: hidden; border-radius: 10px;">
                    <a href="{{ route('login') }}">
                        <img src="{{ asset('images/sauna_1.jpg') }}" class="img-fluid zoom-image" style="width: 100%; height: 100%; object-fit: cover;" alt="Área de Descanso">
                    </a>
                </div>
                <h3 class="h5 mt-3">Sauna Finlandesa</h3>
                <p class="text-muted">Disfruta del calor seco que revitaliza el cuerpo.</p>
            </div>

            <!-- Ambiente 2 -->
            <div class="col-lg-4 col-md-6 mb-5">
                <div class="image-container" style="height: 100%; overflow: hidden; border-radius: 10px;">
                    <a href="{{ route('login') }}">
                        <img src="{{ asset('images/sauna_2.jpg') }}" class="img-fluid zoom-image" style="width: 100%; height: 100%; object-fit: cover;" alt="Área de Descanso">
                    </a>
                </div>
                <h3 class="h5 mt-3">Baño de Vapor</h3>
                <p class="text-muted">Relájate en un ambiente húmedo que purifica tu piel.</p>
            </div>

            <!-- Ambiente 3 -->
            <div class="col-lg-4 col-md-6 mb-5">
                <div class="image-container" style="height: 100%; overflow: hidden; border-radius: 10px;">
                    <a href="{{ route('login') }}">
                        <img src="{{ asset('images/sauna_3.jpg') }}" class="img-fluid zoom-image" style="width: 100%; height: 100%; object-fit: cover;" alt="Área de Descanso">
                    </a>
                </div>
                <h3 class="h5 mt-3">Área de Descanso</h3>
                <p class="text-muted">Relájate entre sesiones en nuestras cómodas áreas de descanso.</p>
            </div>

        </div>
    </div>
</section>

<!-- Sección de Testimonios -->
<section class="py-5 text-center" style="margin-left: 5% ; background-color: #c5c0c0 ;">
    <div class="container">
        <h2 class="fw-bolder mb-5">Lo que Dicen Nuestros Clientes</h2>
        <div class="row gx-5">
            <div class="col-lg-4">
                <blockquote class="blockquote">
                    <p class="fs-5">"Una experiencia increíble. Salí totalmente renovado. ¡Volveré sin duda!"</p>
                    <footer class="blockquote-footer">Juan Pérez</footer>
                </blockquote>
            </div>
            <div class="col-lg-4">
                <blockquote class="blockquote">
                    <p class="fs-5">"El ambiente es relajante y las instalaciones de primera. 100% recomendado."</p>
                    <footer class="blockquote-footer">María Gómez</footer>
                </blockquote>
            </div>
            <div class="col-lg-4">
                <blockquote class="blockquote">
                    <p class="fs-5">"El mejor sauna de la ciudad, ideal para desconectar del estrés diario."</p>
                    <footer class="blockquote-footer">Carlos Rodríguez</footer>
                </blockquote>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Beneficios del Sauna -->
<section class="py-5 text-center" style="margin-left: 5% ; background-color: #c5c0c0 ; padding: 5%">
    <div class="container px-5">
        <h2 class="fw-bolder mb-5">Beneficios de Nuestros Servicios</h2>
        <div class="row gx-5">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <i class="bi bi-heart-pulse fs-1 mb-3"></i>
                        <h3 class="card-title">Mejora la Salud Cardiovascular</h3>
                        <p class="card-text">Nuestros servicios mejoran la circulación sanguínea, lo que beneficia tu salud cardiovascular.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <i class="bi bi-droplet fs-1 mb-3"></i>
                        <h3 class="card-title">Elimina Toxinas</h3>
                        <p class="card-text">El calor de nuestras saunas ayuda a sudar y eliminar toxinas de tu cuerpo de manera efectiva.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <i class="bi bi-flower1 fs-1 mb-3"></i>
                        <h3 class="card-title">Relajación Total</h3>
                        <p class="card-text">Desconecta del estrés y las tensiones diarias en nuestros espacios diseñados para tu bienestar.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

<!-- Estilos CSS personalizados -->
<style>
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
    .img-equal {
        height: 250px;
        object-fit: cover;
    }
</style>
