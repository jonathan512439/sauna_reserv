<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Usamos ms-auto para mover los paneles de Admin y Encargado a la derecha -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @if(Auth::check() && Auth::user()->role === 'admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Panel Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users') }}">Gestión de Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.ambientes') }}">Gestión de Ambientes</a>
                </li>
                @elseif(Auth::check() && Auth::user()->role === 'encargado')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('encargado.dashboard') }}">Panel Encargado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('ambientes.index') }}">Administrar Ambientes</a>
                </li>
                @endif
            </ul>

            <!-- Menú del Usuario a la derecha (Login o Registro) -->
            <ul class="navbar-nav ms-auto">
                @if(Auth::check())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<!-- Verificación de la correcta carga de Bootstrap JS y Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
