@extends('layouts.app')
@section('title', 'Mensajes')
@section('content')

<h2 class="mb-4">Mensajes</h2>

@forelse($conversaciones as $conv)
    <a href="{{ route('mensajes.chat', ['centroId' => $conv->centro_id, 'usuarioId' => $conv->usuario_id]) }}"
       class="text-decoration-none text-dark">
        <div class="card border-0 shadow-sm p-3 mb-2 d-flex flex-row align-items-center gap-3"
             style="border-radius: 12px;">

            {{-- cambia la foto dependiendo si es un centro o cliente--}}
            <div style="width: 48px; height: 48px; border-radius: 50%;
                        background: #e9ecef; display: flex; align-items: center;
                        justify-content: center; overflow: hidden; flex-shrink: 0;">

                @if(auth()->user()->rol === 'centro')
                    {{-- Si el usuario conectado es el centro, muestra el icono de un cliente --}}
                    <i class="bi bi-person" style="font-size: 22px;"></i>
                @else
                    {{-- Si es un cliente, busca la foto principal del centro --}}
                    @php
                        $fotos = $conv->centro->fotosCentro ?? $conv->centro->fotos ?? collect();
                        $fotoPerfil = $fotos->firstWhere('orden', 0);
                    @endphp

                    @if ($fotoPerfil)
                        <img src="{{ asset('storage/' . $fotoPerfil->ruta) }}" alt="avatar"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        {{-- Icono por defecto de tienda si no tiene foto --}}
                        <i class="bi bi-shop" style="font-size: 22px;"></i>
                    @endif
                @endif

            </div>

            <div class="flex-grow-1">
                @if(auth()->user()->rol === 'centro')
                    <strong>{{ $conv->usuario->nombre }}</strong>
                @else
                    <strong>{{ $conv->centro->nombre }}</strong>
                @endif
                <p class="text-muted small mb-0">
                    {{ \Illuminate\Support\Str::limit($conv->mensaje, 60) }}
                </p>
            </div>

            <div class="text-end" style="flex-shrink: 0;">
                <p class="text-muted small mb-0">
                    {{ \Carbon\Carbon::parse($conv->created_at)->diffForHumans() }}
                </p>
                @if($conv->no_leidos > 0)
                    <span class="badge bg-primary rounded-pill">{{ $conv->no_leidos }}</span>
                @endif
            </div>
        </div>
    </a>
@empty
    <p class="text-muted">No tienes conversaciones todavía.</p>
@endforelse

@endsection
