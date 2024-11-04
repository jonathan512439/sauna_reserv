@php
    use Illuminate\Support\Facades\Route;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sistema de Reservas') }}</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <!-- Barra lateral -->
        <header id="header" class="header dark-background d-flex flex-column">
            <div class="profile-img">
                <img src="{{ asset('images/logo_sauna.png') }}" alt="Logo del Sauna" class="img-fluid rounded-circle">
            </div>
            <div class="social-links text-center">
                <a href="#" class="tiktok"><i class="bi bi-tiktok"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            </div>
            <a href="{{ url('/') }}" class="logo d-flex align-items-center justify-content-center">
                <h1 class="sitename">SAUNAS SAN MARQUEZ</h1>
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    @guest
                        <!-- Si no hay usuario logueado, mostrar "Iniciar Sesión" -->
                        <li><a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right navicon"></i> Iniciar Sesión</a></li>
                        <li><a href="{{ route('register') }}"><i class="bi bi-person-plus navicon"></i> Crear Usuario</a></li>
                    @else
                        <!-- Información del Usuario Logeado -->
                        <li><a href="#" class="active"><i class="bi bi-person-circle navicon" ></i> {{ Auth::user()->name }}</a></li>
                        <!-- Si el usuario está logueado, mostrar "Menu" -->
                        <li><a href="{{ route('dashboard') }}" ><i class="bi bi-house navicon"></i> Menu</a></li>

                        <!-- Dependiendo del rol -->
                        @if(Auth::user()->role === 'admin')
                            <li><a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 navicon"></i> Panel Admin</a></li>
                            <!-- Opción para crear nuevo usuario solo visible para administrador -->
                            <li><a href="{{ route('register') }}"><i class="bi bi-person-plus navicon"></i> Crear Usuario</a></li>
                        @elseif(Auth::user()->role === 'encargado')
                            <li><a href="{{ route('encargado.dashboard') }}"><i class="bi bi-gear navicon"></i> Panel Encargado</a></li>
                        @endif

                        <!-- Cerrar Sesión -->
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right navicon"></i> Cerrar sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endguest

                    <!-- Menú Principal -->
                    <li><a href="{{ route('welcome') }}"><i class="bi bi-house-door navicon"></i> Menú Principal</a></li>

                    <!-- Enlace de Contacto visible para todos excepto admin y encargado -->
                    @if(Auth::check() && Auth::user()->role !== 'admin' && Auth::user()->role !== 'encargado')
                        <li><a href="{{ route('contact') }}"><i class="bi bi-envelope navicon"></i> Contacto</a></li>
                    @endif
                </ul>
            </nav>

        </header>

        <!-- Ajustar el contenido principal -->
        <main class="py-4 main-content" style="margin-left: 250px;">
            @yield('content')
        </main>
    </div>

    <!-- Scripts de JavaScript -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>
