    @extends('layouts.public')

    @section('title', 'Bienvenido')

    @section('content')


    <div class="text-center py-5">
        <p class="text-muted small text-uppercase letter-spacing-1 mb-2">Tu app de bienestar</p>
        <h1 class="fw-medium mb-3">Reserva, gestiona y conecta<br>con tu centro favorito</h1>
        <p class="text-muted mb-4">Encuentra peluquerías, centros de estética, fisioterapia y más.<br>Reserva tu cita en segundos.</p>
        <a href="{{ auth()->check() ? route('home') : route('register') }}" class="btn btn-dark me-2">
            Empezar ahora
        </a>
        <a href="{{ auth()->check() ? route('home') : route('login') }}" class="btn btn-outline-secondary">
            Ver centros
        </a>
    </div>

    <hr>

    {{-- Categorías --}}
    <p class="text-muted text-uppercase small fw-medium mb-3">Categorías populares</p>
    <div class="d-flex flex-wrap gap-2 mb-5">
        @foreach($categorias as $cat)
            <a href="{{ route('login') }}"
            class="d-flex align-items-center gap-2 px-3 py-2 border rounded-pill text-decoration-none text-dark"
            style="font-size: 13px;">
                <i class="bi {{ $cat->icono }}"></i> {{ $cat->nombre }}
            </a>
        @endforeach
    </div>

    <hr>

    {{-- Features --}}
    <p class="text-muted text-uppercase small fw-medium mb-3">Todo lo que necesitas</p>
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="card border p-4 h-100" style="border-radius: 12px;">
                <i class="bi bi-calendar mb-3" style="font-size: 24px;"></i>
                <h5 class="fw-medium mb-2">Citas online</h5>
                <p class="text-muted small mb-3">Reserva en cualquier momento, elige servicio, fecha y hora disponible.</p>
                <a href="{{ auth()->check() ? route('citas') : route('login') }}" class="text-dark small">
                    Ver citas <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border p-4 h-100" style="border-radius: 12px;">
                <i class="bi bi-chat mb-3" style="font-size: 24px;"></i>
                <h5 class="fw-medium mb-2">Mensajes directos</h5>
                <p class="text-muted small mb-3">Habla con el centro antes de tu visita. Chat en tiempo real.</p>
                <a href="{{ auth()->check() ? route('mensajes') : route('login') }}" class="text-dark small">
                    Ver mensajes <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border p-4 h-100" style="border-radius: 12px;">
                <i class="bi bi-layout-sidebar mb-3" style="font-size: 24px;"></i>
                <h5 class="fw-medium mb-2">Panel de control</h5>
                <p class="text-muted small mb-3">Gestiona tu centro, servicios, horarios y clientes desde un solo lugar.</p>
                <a href="{{ auth()->check() ? route('home') : route('login') }}" class="text-dark small">
                    Acceder <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <hr>

    {{-- Cómo funciona --}}
    <p class="text-muted text-uppercase small fw-medium mb-3">¿Cómo funciona?</p>
    <div class="row g-3 mb-5">
        <div class="col-md-4 d-flex gap-3">
            <div class="rounded-circle border d-flex align-items-center justify-content-center flex-shrink-0"
                style="width:28px; height:28px; font-size:12px;">1</div>
            <div>
                <h6 class="fw-medium mb-1">Crea tu cuenta</h6>
                <p class="text-muted small mb-0">Regístrate como cliente o como centro en menos de un minuto.</p>
            </div>
        </div>
        <div class="col-md-4 d-flex gap-3">
            <div class="rounded-circle border d-flex align-items-center justify-content-center flex-shrink-0"
                style="width:28px; height:28px; font-size:12px;">2</div>
            <div>
                <h6 class="fw-medium mb-1">Encuentra tu centro</h6>
                <p class="text-muted small mb-0">Busca por categoría o nombre y explora los perfiles.</p>
            </div>
        </div>
        <div class="col-md-4 d-flex gap-3">
            <div class="rounded-circle border d-flex align-items-center justify-content-center flex-shrink-0"
                style="width:28px; height:28px; font-size:12px;">3</div>
            <div>
                <h6 class="fw-medium mb-1">Reserva tu cita</h6>
                <p class="text-muted small mb-0">Elige el servicio, fecha y hora. El centro confirma al instante.</p>
            </div>
        </div>
    </div>

    {{-- CTA centros --}}
    <div class="bg-light rounded-3 p-5 text-center mb-4">
        <h2 class="fw-medium mb-2">¿Tienes un centro?</h2>
        <p class="text-muted mb-4">Únete y empieza a recibir reservas online hoy mismo. Gratis.</p>
        <a href="{{ route('register') }}" class="btn btn-dark">
            Registrar mi centro
        </a>
    </div>

    @endsection
