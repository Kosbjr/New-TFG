<!DOCTYPE html>
<html lang="es">
<head>
    @livewireStyles
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>@yield('title')</title>
</head>
@livewireScripts
<body class="d-flex">

@auth
    {{-- barra lateral --}}
    <aside class="bg-dark text-white p-3 vh-100" style="width: 250px;">

        <h4 class="mb-4">Mi Espacio</h4>

        <a class="text-white d-block mb-2" href="{{ route('home') }}">Home</a>
        <a class="text-white d-block mb-2" href="{{ route('mensajes') }}">Mensajes</a>
        <a class="text-white d-block mb-2" href="{{ route('citas') }}">Citas</a>
        @if(auth()->user()->rol === 'centro')
        <a class="text-white d-block mb-2" href="/centro/mi-centro">
            Mi centro
        </a>
    @endif

        <hr>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger w-100">Logout</button>
        </form>

    </aside>
@endauth


    <main class="p-4 flex-grow-1">
        @yield('content')
    </main>

</body>
</html>
