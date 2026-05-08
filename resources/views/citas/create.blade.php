@extends('layouts.app')
@section('title', 'Agendar cita')
@section('content')

<div class="mb-3">
    <a href="{{ route('centro.show', $centro->id) }}" class="text-muted small">← Volver</a>
</div>

<h2 class="mb-4">Agendar cita en {{ $centro->nombre }}</h2>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm p-4" style="border-radius:12px">

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $e)
                        <p class="mb-0">{{ $e }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('citas.store', $centro->id) }}" method="POST">
                @csrf

                {{-- Servicio --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Selecciona un servicio</label>
                    @forelse($centro->servicios as $s)
                        <div class="form-check p-3 mb-2" style="background:#f8f8f8; border-radius:8px">
                            <input class="form-check-input" type="radio"
                                   name="servicio_id" value="{{ $s->id }}"
                                   id="s{{ $s->id }}" required>
                            <label class="form-check-label w-100 d-flex justify-content-between" for="s{{ $s->id }}">
                                <div>
                                    <strong>{{ $s->nombre }}</strong>
                                    @if($s->descripcion)
                                        <span class="text-muted small d-block">{{ $s->descripcion }}</span>
                                    @endif
                                </div>
                                <span class="text-nowrap ms-3">
                                    {{ $s->duracion }} min · <strong>{{ number_format($s->precio, 2) }}€</strong>
                                </span>
                            </label>
                        </div>
                    @empty
                        <p class="text-muted">Este centro aún no tiene servicios disponibles.</p>
                    @endforelse
                </div>

                {{-- Fecha --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Fecha</label>
                    @if(empty($huecos))
                        <p class="text-muted small">Este centro no tiene horarios disponibles en los próximos 14 días.</p>
                    @else
                        <select name="fecha" id="fecha" class="form-select" required>
                            <option value="">Selecciona una fecha</option>
                            @foreach($huecos as $fecha => $horas)
                                <option value="{{ $fecha }}">
                                    {{ \Carbon\Carbon::parse($fecha)->translatedFormat('l, d \d\e M') }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>

                {{-- Hora --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Hora</label>
                    <select name="hora" id="hora" class="form-select" required>
                        <option value="">Primero selecciona una fecha</option>
                    </select>
                </div>

                {{-- Notas --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Notas (opcional)</label>
                    <textarea name="notas" rows="2" class="form-control"
                              placeholder="Ej: alergia a ciertos productos..."></textarea>
                </div>

                <button class="btn btn-primary w-100" {{ empty($huecos) ? 'disabled' : '' }}>
                    Confirmar cita
                </button>
            </form>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm p-4" style="border-radius:12px">
            <h6 class="mb-3">{{ $centro->nombre }}</h6>
            @if($centro->direccion)
                <p class="text-muted small mb-1">📍 {{ $centro->direccion }}</p>
            @endif
            @if($centro->telefono)
                <p class="text-muted small mb-0">📞 {{ $centro->telefono }}</p>
            @endif
        </div>
    </div>
</div>

<script>
    const huecos = @json($huecos);
    document.getElementById('fecha').addEventListener('change', function () {
        const horaSelect = document.getElementById('hora');
        horaSelect.innerHTML = '<option value="">Selecciona una hora</option>';
        (huecos[this.value] || []).forEach(h => {
            const opt = document.createElement('option');
            opt.value = h;
            opt.textContent = h;
            horaSelect.appendChild(opt);
        });
    });
</script>

@endsection
