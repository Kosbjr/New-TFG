@extends('layouts.app')
@section('title', 'Citas')
@section('content')

    <h2 class="mb-4">Mis citas</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse($citas as $cita)
        <div class="card border-0 shadow-sm p-3 mb-3" style="border-radius:12px">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    @if ($user->rol === 'centro')
                        <strong>{{ $cita->usuario->nombre }}</strong>
                    @else
                        <strong>{{ $cita->centro->nombre }}</strong>
                    @endif

                    @if ($cita->servicio)
                        <span class="badge bg-secondary ms-2">{{ $cita->servicio->nombre }}</span>
                    @endif

                    <p class="mb-1 text-muted small mt-1">
                        <i class="bi bi-calendar-plus"></i> {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                        <i class="bi bi-arrow-right"></i> <i class="bi bi-alarm"></i> {{ $cita->hora }}
                        @if ($cita->servicio)
                            · {{ number_format($cita->servicio->precio, 2) }}€
                        @endif
                    </p>

                    @if ($cita->notas)
                        <p class="mb-0 small text-muted"><i class="bi bi-pencil-square"></i> {{ $cita->notas }}</p>
                    @endif
                </div>

                <div class="text-end">
                    <span
                        class="badge
                    {{ $cita->estado === 'confirmada'
                        ? 'bg-success'
                        : ($cita->estado === 'cancelada'
                            ? 'bg-danger'
                            : 'bg-warning text-dark') }}">
                        {{ ucfirst($cita->estado) }}
                    </span>

                    {{-- Nombre del cliente visible siempre para el centro --}}
                    @if ($user->rol === 'centro' && $cita->estado === 'confirmada')
                        <p class="text-muted small mt-1 mb-0">
                            Cliente: {{ $cita->usuario->nombre }}
                        </p>
                    @endif

                    @if ($user->rol === 'centro' && $cita->estado === 'pendiente')
                        <div class="mt-2 d-flex gap-1">
                            <form action="{{ route('citas.estado', $cita->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="estado" value="confirmada">
                                <button class="btn btn-sm btn-success">Confirmar</button>
                            </form>
                            <form action="{{ route('citas.estado', $cita->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="estado" value="cancelada">
                                <button class="btn btn-sm btn-outline-danger">Cancelar</button>
                            </form>
                        </div>
                    @endif

                    @php
                        $usuarioId = $user->rol === 'centro' ? $cita->usuario_id : $user->id;
                    @endphp
                    <a href="{{ route('mensajes.chat', ['centroId' => $cita->centro_id, 'usuarioId' => $usuarioId]) }}"
                        class="btn btn-sm btn-outline-primary mt-2">
                        <i class="bi bi-chat-dots"></i> Mensaje
                    </a>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">No tienes citas todavía.</p>
    @endforelse

@endsection
