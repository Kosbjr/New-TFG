@extends('layouts.app')

@section('title', $centro->nombre)

@section('content')

    <div class="mb-3">
        <a href="{{ route('home') }}" class="text-muted small">← Volver</a>
    </div>

    {{-- Foto principal --}}
    @if ($centro->fotos->count())
        @php $fotoPrincipal = $centro->fotos->firstWhere('orden', 0) ?? $centro->fotos->first(); @endphp
        <div class="mb-3">
            <img src="{{ asset('storage/' . $fotoPrincipal->ruta) }}" alt="{{ $centro->nombre }}"
                style="width: 100%; height: 450px; object-fit: cover; border-radius: 12px;">
        </div>
    @else
        <div class="d-flex align-items-center justify-content-center mb-4"
            style="height: 250px; background: #f5f5f5; border-radius: 12px;">
            <i class="bi bi-scissors" style="font-size: 64px;"></i>
        </div>
    @endif

    {{-- Contenido principal --}}
    <div class="row g-4">

        {{-- Izquierda: nombre, descripción y galería --}}
        <div class="col-lg-8">
            <h2 class="mb-1">{{ $centro->nombre }}</h2>

            @if ($centro->descripcion)
                <p class="text-muted mt-2">{{ $centro->descripcion }}</p>
            @endif

            {{-- Galería --}}
            @php $galeria = $centro->fotos->where('orden', '>', 0); @endphp
            @if ($galeria->count())
                <h6 class="text-muted small text-uppercase fw-medium mb-2 mt-4">Galería</h6>
                <div class="row g-2">
                    @foreach ($galeria as $foto)
                        <div class="col-3">
                            <img src="{{ asset('storage/' . $foto->ruta) }}" alt="{{ $centro->nombre }}"
                                style="width: 100%; height: 220px; object-fit: cover; border-radius: 6px;
                                        cursor: pointer; transition: opacity 0.2s;"
                                onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- panel de información --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 12px; position: sticky; top: 20px;">

                <h5 class="mb-3">Información</h5>

                @if ($centro->ubicacion)
                    <div class="d-flex align-items-start gap-2 mb-2">
                        <i class="bi bi-pin-map-fill"></i>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($centro->ubicacion) }}"
                            target="_blank" class="text-decoration-none">
                            {{ $centro->ubicacion }}
                        </a>
                    </div>
                @endif

                @if ($centro->telefono)
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-telephone"></i>
                        <span>{{ $centro->telefono }}</span>
                    </div>
                @endif

                @if ($centro->categorias->count())
                    <div class="d-flex flex-wrap gap-1 mb-3">
                        @foreach ($centro->categorias as $cat)
                            <span class="badge bg-light text-dark" style="font-size:11px">
                                <i class="bi {{ $cat->icono }}"></i> {{ $cat->nombre }}
                            </span>
                        @endforeach
                    </div>
                @endif

                @auth
                    @if (auth()->user()->rol === 'cliente')
                        <a href="{{ route('citas.create', $centro->id) }}" class="btn btn-primary w-100 mt-2">
                            <i class="bi bi-calendar-plus"></i> Agendar cita
                        </a>
                        <a href="{{ route('mensajes.chat', ['centroId' => $centro->id, 'usuarioId' => auth()->id()]) }}"
                            class="btn btn-outline-primary w-100 mt-2">
                            <i class="bi bi-chat-dots"></i> Contactar
                        </a>
                        <form action="{{ route('favoritos.toggle', $centro->id) }}" method="POST" class="mt-2">
                            @csrf
                            <button class="btn w-100 {{ $esFavorito ? 'btn-danger' : 'btn-outline-danger' }}">
                                <i class="bi {{ $esFavorito ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                {{ $esFavorito ? 'Quitar de favoritos' : 'Guardar en favoritos' }}
                            </button>
                        </form>
                    @endif
                @endauth

            </div>
        </div>

    </div>

@endsection
