@extends('layouts.app')

@section('title', 'Editar información del centro')

@section('content')

<div class="container py-4">

    <h2 class="mb-4">
        {{ $centro ? 'Editar información' : 'Añadir información' }}
    </h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- =========================
        FORM CENTRO
    ========================== --}}
    <form
        action="{{ route('centro.update') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        {{-- NOMBRE --}}
        <div class="mb-3">
            <label class="form-label">Nombre del centro *</label>
            <input type="text" name="nombre" class="form-control"
                   value="{{ old('nombre', $centro?->nombre) }}" required>
        </div>

        {{-- DIRECCIÓN --}}
        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control"
                   value="{{ old('direccion', $centro?->direccion) }}">
        </div>

        {{-- UBICACIÓN --}}
        <div class="mb-3">
            <label class="form-label">Ubicación</label>
            <input type="text" name="ubicacion" class="form-control"
                   value="{{ old('ubicacion', $centro?->ubicacion) }}"
                   placeholder="Ej: Calle Gran Vía 14, Madrid">

            <div class="form-text">
                Esta dirección se usará para Google Maps.
            </div>
        </div>

        {{-- TELÉFONO --}}
        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control"
                   value="{{ old('telefono', $centro?->telefono) }}">
        </div>

        {{-- DESCRIPCIÓN --}}
        <div class="mb-4">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" rows="4"
                      class="form-control">{{ old('descripcion', $centro?->descripcion) }}</textarea>
        </div>

        {{-- FOTOS --}}
        <div class="mb-4">
            <label class="form-label">Fotos del establecimiento</label>

            @if ($centro?->fotos->count())
                <div class="d-flex flex-wrap gap-2 mb-3">
                    @foreach ($centro->fotos as $foto)
                        <div class="position-relative">

                            <img src="{{ asset('storage/' . $foto->ruta) }}"
                                 style="width:120px;height:90px;object-fit:cover;border-radius:8px;">

                            <form action="{{ route('centro.foto.eliminar', $foto->id) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        style="position:absolute;top:4px;right:4px;
                                               background:rgba(0,0,0,0.6);color:#fff;
                                               border:none;border-radius:50%;
                                               width:22px;height:22px;font-size:12px;">
                                    ✕
                                </button>
                            </form>

                        </div>
                    @endforeach
                </div>
            @endif

            <input type="file" name="fotos[]" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">
            Guardar
        </button>

        <a href="{{ route('home') }}" class="btn btn-secondary ms-2">
            Cancelar
        </a>

    </form>

    {{-- =========================
        FORM CATEGORÍAS (SEPARADO)
    ========================== --}}
    <div class="card border-0 shadow-sm p-4 mt-4" style="border-radius:12px">

        <h5 class="mb-3">Categorías del centro</h5>

        <form action="{{ route('centro.categorias.update') }}" method="POST">
            @csrf

            <div class="row g-2 mb-3">
                @foreach($categorias as $cat)

                    <div class="col-6 col-md-4">
                        <div class="form-check p-2" style="background:#f8f8f8;border-radius:8px">

                            <input class="form-check-input"
                                   type="checkbox"
                                   name="categorias[]"
                                   value="{{ $cat->id }}"
                                   id="cat{{ $cat->id }}"
                                   {{ $centro && $centro->categorias->contains($cat->id) ? 'checked' : '' }}>

                            <label class="form-check-label" for="cat{{ $cat->id }}">
                                <i class="bi {{ $cat->icono }}"></i>
                                {{ $cat->nombre }}
                            </label>

                        </div>
                    </div>

                @endforeach
            </div>

            <button class="btn btn-primary btn-sm">
                Guardar categorías
            </button>

        </form>

    </div>

</div>

@endsection
