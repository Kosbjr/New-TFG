@extends('layouts.app')
@section('title', 'Categorías')
@section('content')

<h2 class="mb-4">Gestión de categorías</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm p-4" style="border-radius:12px">
            @forelse($categorias as $cat)
                <div class="d-flex justify-content-between align-items-center mb-2 p-2"
                     style="background:#f8f8f8; border-radius:8px">
                    <span><i class="bi {{ $cat->icono }}"></i> <strong>{{ $cat->nombre }}</strong>
                        <span class="text-muted small ms-2">{{ $cat->centros_count }} centros</span>
                    </span>
                    <form action="{{ route('admin.categorias.destroy', $cat->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">✕</button>
                    </form>
                </div>
            @empty
                <p class="text-muted">No hay categorías todavía.</p>
            @endforelse
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm p-4" style="border-radius:12px">
            <h5 class="mb-3">Nueva categoría</h5>
            <form action="{{ route('admin.categorias.store') }}" method="POST">
                @csrf
                @if($errors->any())
                    <div class="alert alert-danger small">
                        @foreach($errors->all() as $e) <p class="mb-0">{{ $e }}</p> @endforeach
                    </div>
                @endif
                <div class="mb-2">
                    <input type="text" name="nombre" class="form-control"
                           placeholder="Nombre *" required>
                </div>
                <div class="mb-2">
                    <input type="text" name="icono" class="form-control"
                           placeholder="Icono (emoji)">
                </div>
                <div class="mb-3">
                    <input type="text" name="slug" class="form-control"
                           placeholder="Slug (ej: peluqueria) *" required>
                </div>
                <button class="btn btn-primary w-100">Añadir categoría</button>
            </form>
        </div>
    </div>
</div>

@endsection
