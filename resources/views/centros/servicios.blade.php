@extends('layouts.app')
@section('title', 'Mis servicios')
@section('content')

<h2 class="mb-4">Servicios y horarios</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-4">

    {{-- Servicios --}}
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm p-4" style="border-radius:12px">
            <h5 class="mb-3">Servicios</h5>

            @forelse($centro->servicios as $s)
                <div class="d-flex justify-content-between align-items-center mb-2 p-2"
                     style="background:#f8f8f8; border-radius:8px">
                    <div>
                        <strong>{{ $s->nombre }}</strong><br>
                        <span class="small text-muted">{{ $s->descripcion }}</span><br>
                        <span class="small">{{ $s->duracion }} min — {{ number_format($s->precio, 2) }}€</span>
                    </div>
                    <form action="{{ route('servicios.destroy', $s->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">✕</button>
                    </form>
                </div>
            @empty
                <p class="text-muted small">Aún no has añadido servicios.</p>
            @endforelse

            <form action="{{ route('servicios.store') }}" method="POST" class="mt-3">
                @csrf
                <div class="row g-2">
                    <div class="col-12">
                        <input type="text" name="nombre" class="form-control form-control-sm"
                               placeholder="Nombre del servicio *" required>
                    </div>
                    <div class="col-12">
                        <input type="text" name="descripcion" class="form-control form-control-sm"
                               placeholder="Descripción (opcional)">
                    </div>
                    <div class="col-6">
                        <input type="number" name="precio" class="form-control form-control-sm"
                               placeholder="Precio €*" step="0.01" min="0" required>
                    </div>
                    <div class="col-6">
                        <input type="number" name="duracion" class="form-control form-control-sm"
                               placeholder="Duración min *" value="30" min="15" required>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary btn-sm w-100">Añadir servicio</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Horarios --}}
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm p-4" style="border-radius:12px">
            <h5 class="mb-3">Horarios disponibles</h5>

            @php
                $dias = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];
            @endphp

            @forelse($centro->horarios as $h)
                <div class="d-flex justify-content-between align-items-center mb-2 p-2"
                     style="background:#f8f8f8; border-radius:8px">
                    <span>
                        {{ $dias[$h->dia_semana] }} · {{ $h->hora_inicio }} – {{ $h->hora_fin }}
                        <span class="text-muted small">(cada {{ $h->intervalo_minutos }} min)</span>
                    </span>
                    <form action="{{ route('horarios.destroy', $h->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">✕</button>
                    </form>
                </div>
            @empty
                <p class="text-muted small">Aún no has definido horarios.</p>
            @endforelse

            <form action="{{ route('horarios.store') }}" method="POST" class="mt-3">
                @csrf
                <div class="row g-2">
                    <div class="col-12">
                        <select name="dia_semana" class="form-select form-select-sm" required>
                            @foreach($dias as $i => $d)
                                <option value="{{ $i }}">{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <input type="time" name="hora_inicio" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-4">
                        <input type="time" name="hora_fin" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-4">
                        <input type="number" name="intervalo_minutos" class="form-control form-control-sm"
                               placeholder="Intervalo" value="30" min="15" required>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary btn-sm w-100">Añadir horario</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
