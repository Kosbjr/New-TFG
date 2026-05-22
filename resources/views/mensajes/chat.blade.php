@extends('layouts.app')
@section('title', 'Chat')
@section('content')

    <div class="mb-3">
        <a href="{{ route('mensajes') }}" class="text-muted small">← Volver a mensajes</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius: 14px;">
                <div class="d-flex align-items-center gap-3">

                    @if (auth()->user()->rol === 'centro')

                        @php
                            $cliente = \App\Models\User::find($usuarioId);
                        @endphp

                        <div style="width: 44px; height: 44px; border-radius: 50%;
                                    background: #e9ecef; display: flex;
                                    align-items: center; justify-content: center;
                                    overflow: hidden; flex-shrink: 0;">
                            <i class="bi bi-person" style="font-size: 20px;"></i>
                        </div>

                        <div>
                            <h5 class="mb-0">{{ $cliente ? $cliente->nombre : 'Usuario' }}</h5>
                            <p class="text-muted small mb-0">Cliente</p>
                        </div>

                    @else

                        @php
                            $fotos = $centro->fotosCentro ?? collect();
                            $fotoPerfil = $fotos->firstWhere('orden', 0);
                        @endphp

                        <div style="width: 44px; height: 44px; border-radius: 50%;
                                    background: #e9ecef; display: flex;
                                    align-items: center; justify-content: center;
                                    overflow: hidden; flex-shrink: 0;">
                            @if ($fotoPerfil)
                                <img src="{{ asset('storage/' . $fotoPerfil->ruta) }}" alt="avatar"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="bi bi-shop" style="font-size: 20px;"></i>
                            @endif
                        </div>

                        <div>
                            <h5 class="mb-0">{{ $centro->nombre }}</h5>
                            @if ($centro->direccion)
                                <p class="text-muted small mb-0">
                                    {{ $centro->direccion }}
                                </p>
                            @endif
                        </div>
                    @endif

                </div>
            </div>


            @livewire('chat', [
                'centroId' => $centro->id,
                'usuarioId' => $usuarioId,
            ])

        </div>
    </div>

@endsection
