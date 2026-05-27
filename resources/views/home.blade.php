@extends('layouts.app')

@section('title', 'Home')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <h2>BIENVENID@ A GlowMe</h2>


    @if ($modo === 'cliente')
        {{-- Filtro de categorías múltiple --}}
        @php

            $categoriasActivas = request('categorias') ? explode(',', request('categorias')) : [];
        @endphp

        <div class="d-flex flex-wrap gap-2 mb-4">

            <a href="{{ route('home') }}" class="btn btn-sm"
                style="{{ empty($categoriasActivas)
                    ? 'background-color:#16a085; border-color:#16a085; color:white;'
                    : 'border-color:#16a085; color:#16a085;' }}">
                Todos
            </a>

            @foreach ($categorias as $cat)
                @php
                    $estaActiva = in_array($cat->slug, $categoriasActivas);
                    if ($estaActiva) {
                        $nuevasCategorias = array_diff($categoriasActivas, [$cat->slug]);
                    } else {
                        $nuevasCategorias = array_merge($categoriasActivas, [$cat->slug]);
                    }

                    $parametroUrl = !empty($nuevasCategorias) ? implode(',', $nuevasCategorias) : null;
                @endphp

                <a href="{{ route('home', ['categorias' => $parametroUrl]) }}" class="btn btn-sm"
                    style="{{ $estaActiva
                        ? 'background-color:#16a085; border-color:#16a085; color:white;'
                        : 'border-color:#16a085; color:dark-grey;' }}">
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

        {{-- sobre ti --}}
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

                        @if ($centro->ubicacion)
                            <dt class="col-sm-3">Ubicación</dt>
                            <dd class="col-sm-9">
                                <a href="https://www.google.com/maps/search/{{ urlencode($centro->ubicacion) }}"
                                    target="_blank">
                                    <i class="bi bi-geo-alt"></i> {{ $centro->ubicacion }}
                                </a>
                            </dd>
                        @endif
                    </dl>

                    @if ($centro->fotos->count())
                        {{-- Foto principal --}}
                        @php $fotoPrincipal = $centro->fotos->firstWhere('orden', 0) ?? $centro->fotos->first(); @endphp
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $fotoPrincipal->ruta) }}" alt="{{ $centro->nombre }}"
                                style="width: 100%; height: 350px; object-fit: cover; border-radius: 10px;">
                        </div>
                        <hr>
                        {{-- Galería --}}
                        @php $galeria = $centro->fotos->where('orden', '>', 0); @endphp
                        @if ($galeria->count())
                            <h6 class="text-muted small text-uppercase fw-medium mb-2">Galería</h6>
                            <div class="row g-2">
                                @foreach ($galeria as $foto)
                                    <div class="col-3">
                                        <img src="{{ asset('storage/' . $foto->ruta) }}" alt="{{ $centro->nombre }}"
                                            style="width: 100%; height: 250px; object-fit: cover; border-radius: 6px;
                            cursor: pointer; transition: opacity 0.2s;"
                                            onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                                    </div>
                                @endforeach
                            </div>
                        @endif
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
        {{-- Zona de Borado de cuenta --}}

        <div class="card-body">


            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminarCuenta">
                <i class="bi bi-trash"></i> Eliminar cuenta
            </button>
        </div>


        {{-- Modal de confirmación --}}
        <div class="modal fade" id="modalEliminarCuenta" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-danger">¿Eliminar cuenta?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small">Esta acción es irreversible.
                        <p class="text-muted small mb-3">
                            Al eliminar tu cuenta se borrarán todos tus datos, fotos, servicios y citas de forma permanente.
                        </p> Introduce tu contraseña para confirmar.</p>
                        <form action="{{ route('cuenta.destroy') }}" method="POST" id="formEliminarCuenta">
                            @csrf
                            @method('DELETE')
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control"
                                    placeholder="Tu contraseña actual" required>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" form="formEliminarCuenta" class="btn btn-danger btn-sm">
                            Sí, eliminar mi cuenta
                        </button>
                    </div>
                </div>
            </div>
        </div>

    @endif

@endsection
