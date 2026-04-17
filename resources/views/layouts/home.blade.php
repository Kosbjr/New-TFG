@php
    $user = auth()->user();
@endphp

<aside class="bg-dark text-white p-3 vh-100" style="width: 250px;">

    <h4 class="mb-4">Mi Espacio</h4>

    {{-- CLIENTE --}}
    @if($user->rol === 'cliente')

        <a class="text-white d-block mb-2" href="{{ route('home') }}">Home</a>
        <a class="text-white d-block mb-2" href="/mensajes">Mensajes</a>
        <a class="text-white d-block mb-2" href="/citas">Citas</a>

    @endif

    {{-- CENTRO --}}
    @if($user->rol === 'centro')

        <a class="text-white d-block mb-2" href="{{ route('home') }}">Panel</a>

        <a class="text-white d-block mb-2" href="/mensajes">
            Mensajes pendientes
        </a>

        <a class="text-white d-block mb-2" href="/centro/mi-centro">
        Mi centro
        </a>

        <a class="text-white d-block mb-2" href="/citas">
            Citas
        </a>

    @endif

    <hr>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger w-100">Logout</button>
    </form>

</aside>
