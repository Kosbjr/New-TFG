<!DOCTYPE html>
<html lang="es">

<head>
    @livewireStyles
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>@yield('title')</title>

    <style>
        .sidebar-link {
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
        }

        .sidebar-link:hover {
            background-color: #1abc9c !important;
            color: #ffffff !important;
            padding-left: 20px;
        }

        .sidebar-search .form-control,
        .sidebar-search .form-select {
            background-color: #2c3e50;
            border: 1px solid #4f5d73;
            color: #ffffff;
        }

        .sidebar-search .form-control::placeholder {
            color: #a0aab2;
        }

        .sidebar-search .form-control:focus,
        .sidebar-search .form-select:focus {
            background-color: #2c3e50;
            border-color: #1abc9c;
            box-shadow: 0 0 0 0.25rem rgba(26, 188, 156, 0.25);
            color: #ffffff;
        }

        /* Estilo personalizado para la flecha del select oscuro en Bootstrap */
        .sidebar-search .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        }

        .sidebar-search .btn-search {
            background-color: #1abc9c;
            border: none;
            color: white;
        }

        .sidebar-search .btn-search:hover {
            background-color: #16a085;
            color: white;
        }
    </style>
</head>
@livewireScripts

<body class="d-flex">

    @auth
        <aside class="bg-dark text-white p-3 vh-100" style="width: 250px;">

            <h4 class="mb-4 px-2">Mi Espacio</h4>

            @if (auth()->user()->rol === 'cliente')
                <div class="sidebar-search mb-4 px-2">
                    <form action="{{ route('home') }}" method="GET">
                        {{-- Mantenemos las categorías activas para que no se pisen al buscar desde la barra lateral --}}
                        @if(request('categorias'))
                            <input type="hidden" name="categorias" value="{{ request('categorias') }}">
                        @endif

                        {{-- Input superior de texto --}}
                        <div class="input-group mb-2">
                            <input type="text" name="buscar" class="form-control form-control-sm"
                                placeholder="Buscar centros..." value="{{ request('buscar') }}">
                            <button class="btn btn-sm btn-search" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>

                        {{-- Desplegable inferior de Comunidades Autónomas --}}
                        {{-- Se envía automáticamente al cambiar la opción (onchange) --}}
                        <select name="ciudad" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Todas las comunidades</option>
                            {{-- Condicional de seguridad por si la variable compartida aún no se ha cargado --}}
                            @if(isset($comunidades))
                                @foreach($comunidades as $slug => $nombre)
                                    <option value="{{ $slug }}" {{ request('ciudad') === $slug ? 'selected' : '' }}>
                                        {{ $nombre }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </form>
                </div>
            @endif

            <hr>

            <a class="text-white d-block mb-2 sidebar-link" href="{{ route('home') }}">
                <i class="bi bi-house-door me-2"></i> Home
            </a>
            <a class="text-white d-block mb-2 sidebar-link" href="{{ route('mensajes') }}">
                <i class="bi bi-envelope me-2"></i> Mensajes
            </a>
            <a class="text-white d-block mb-2 sidebar-link" href="{{ route('citas') }}">
                <i class="bi bi-calendar-event me-2"></i> Citas
            </a>
            @if (auth()->user()->rol === 'cliente')
                <a class="text-white d-block mb-2 sidebar-link" href="{{ route('favoritos') }}">
                    <i class="bi bi-heart me-2"></i> Favoritos
                </a>
            @endif

            <hr>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-warning w-100">Cerrar Sesion</button>
            </form>

        </aside>
    @endauth

    <main class="p-4 flex-grow-1 @yield('main-class')">
        @yield('content')
    </main>

</body>

</html>
