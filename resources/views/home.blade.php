@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <h2>BIENVENID@</h2>

    @if ($modo === 'cliente')
        {{-- Filtro de categorías --}}
        <div class="d-flex flex-wrap gap-2 mb-4">
            <a href="{{ route('home') }}"
                class="btn btn-sm {{ !request('categoria') ? 'btn-primary' : 'btn-outline-secondary' }}">
                Todos
            </a>
            @foreach ($categorias as $cat)
                <a href="{{ route('home', ['categoria' => $cat->slug]) }}"
                    class="btn btn-sm {{ request('categoria') === $cat->slug ? 'btn-primary' : 'btn-outline-secondary' }}">
                    <i class="bi {{ $cat->icono }}"></i> {{ $cat->nombre }}
                </a>
            @endforeach
        </div>

        <p class="mb-4">Centros recomendados:</p>
        <div class="row g-4">
            @foreach ($centros as $centro)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('centro.show', $centro->id) }}" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm border-0"
                            style="border-radius: 12px; overflow: hidden; transition: transform 0.2s;"
                            onmouseover="this.style.transform='translateY(-4px)'"
                            onmouseout="this.style.transform='translateY(0)'">

                            <div style="height: 200px; overflow: hidden; background: #f0f0f0;">
                                @php $primerFoto = $centro->fotos->first(); @endphp
                                @if ($primerFoto)
                                    <img src="{{ asset('storage/' . $primerFoto->ruta) }}" alt="{{ $centro->nombre }}"
                                        style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                        <i class="bi bi-scissors" style="font-size: 48px;"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body">
                                <h5 class="card-title mb-1">{{ $centro->nombre }}</h5>
                                @if ($centro->direccion)
                                    <p class="text-muted small mb-2">
                                        <i class="bi bi-geo-alt"></i> {{ $centro->direccion }}
                                    </p>
                                @endif
                                @if ($centro->descripcion)
                                    <p class="card-text small text-muted">
                                        {{ Str::limit($centro->descripcion, 80) }}
                                    </p>
                                @endif
                                @if ($centro->categorias->count())
                                    <div class="d-flex flex-wrap gap-1 mt-2">
                                        @foreach ($centro->categorias as $cat)
                                            <span class="badge bg-light text-dark" style="font-size:11px">
                                                <i class="bi {{ $cat->icono }}"></i> {{ $cat->nombre }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                        </div>
                    </a>
                </div>
            @endforeach
        </div>

    @else
        <h3>Panel del centro</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('servicios.index') }}" class="btn btn-outline-primary btn-sm mb-4">
            <i class="bi bi-tools"></i> Gestionar servicios y horarios
        </a>

        {{-- SECCIÓN: SOBRE TI --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Sobre ti</h5>
                @if ($centro)
                    <a href="{{ route('centros.editar') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i> Editar información
                    </a>
                @endif
            </div>

            <div class="card-body">
                @if ($centro)
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Nombre</dt>
                        <dd class="col-sm-9">{{ $centro->nombre }}</dd>

                        <dt class="col-sm-3">Dirección</dt>
                        <dd class="col-sm-9">{{ $centro->direccion ?? '—' }}</dd>

                        <dt class="col-sm-3">Teléfono</dt>
                        <dd class="col-sm-9">{{ $centro->telefono ?? '—' }}</dd>

                        <dt class="col-sm-3">Descripción</dt>
                        <dd class="col-sm-9">{{ $centro->descripcion ?? '—' }}</dd>

                        @if ($centro->direccion)
                            <dt class="col-sm-3">Ubicación</dt>
                            <dd class="col-sm-9">
                                <a href="https://www.google.com/maps/search/{{ urlencode($centro->direccion) }}"
                                    target="_blank">
                                    <i class="bi bi-geo-alt"></i> {{ $centro->direccion }}
                                </a>
                            </dd>
                        @endif
                    </dl>

                    @if ($centro->fotos->count())
                        <div class="row g-2 mt-3">
                            @foreach ($centro->fotos as $index => $foto)
                                <div class="{{ $index === 0 ? 'col-12' : 'col-4' }}">
                                    <img src="{{ asset('storage/' . $foto->ruta) }}" alt="{{ $centro->nombre }}"
                                        style="width: 100%; height: {{ $index === 0 ? '350px' : '120px' }};
                                               object-fit: cover; border-radius: 10px;">
                                </div>
                            @endforeach
                        </div>
                    @endif

                @else
                    <p class="text-muted mb-3">
                        Aún no has completado la información de tu centro.
                        Añádela para que los clientes puedan encontrarte.
                    </p>
                    <a href="{{ route('centros.editar') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Añadir información
                    </a>
                @endif
            </div>
        </div>

    @endif

@endsection
