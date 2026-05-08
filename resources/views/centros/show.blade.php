@extends('layouts.app')

@section('title', $centro->nombre)

@section('content')

    <div class="mb-3">
        <a href="{{ route('home') }}" class="text-muted small">← Volver</a>
    </div>

    {{-- Galería de fotos --}}
    @if ($centro->fotos->count())
        <div class="row g-2 mb-4">
            @foreach ($centro->fotos as $index => $foto)
                <div class="{{ $index === 0 ? 'col-12' : 'col-4' }}">
                    <img src="{{ asset('storage/' . $foto->ruta) }}" alt="{{ $centro->nombre }}" class="w-100"
                        style="height: {{ $index === 0 ? '350px' : '120px' }};
                            object-fit: cover; border-radius: 10px;">
                </div>
            @endforeach
        </div>
    @else
        <div class="d-flex align-items-center justify-content-center mb-4"
            style="height: 250px; background: #f5f5f5; border-radius: 12px;">
            <span style="font-size: 64px;">✂️</span>
        </div>
    @endif

    {{-- Contenido principal --}}
    <div class="row g-4">

        {{-- Izquierda: nombre y descripción --}}
        <div class="col-lg-8">
            <h2 class="mb-1">{{ $centro->nombre }}</h2>

            @if ($centro->descripcion)
                <p class="text-muted mt-2">{{ $centro->descripcion }}</p>
            @endif
        </div>

        {{-- Derecha: panel de información --}}
        <div class="card border-0 shadow-sm p-4" style="border-radius: 12px;">

            <h5 class="mb-3">Información</h5>

            @if ($centro->direccion)
                <div class="d-flex align-items-start gap-2 mb-2">
                    <span>📍</span>
                    <a href="https://www.google.com/maps/search/{{ urlencode($centro->direccion) }}" target="_blank"
                        class="text-decoration-none">
                        {{ $centro->direccion }}
                    </a>
                </div>
            @endif

            @if ($centro->telefono)
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span>📞</span>
                    <span>{{ $centro->telefono }}</span>
                </div>
            @endif

            @auth
                @if (auth()->user()->rol === 'cliente')
                    <a href="{{ route('citas.create', $centro->id) }}" class="btn btn-primary w-100 mt-2">
                        📅 Agendar cita
                    </a>
                    <a href="{{ route('mensajes.chat', ['centroId' => $centro->id, 'usuarioId' => auth()->id()]) }}"
                        class="btn btn-outline-primary w-100 mt-2">
                        💬 Contactar
                    </a>
                @endif
            @endauth

        </div>

    </div>

@endsection
