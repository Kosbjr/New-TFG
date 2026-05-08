@extends('layouts.app')
@section('title', 'Chat')
@section('content')

<div class="mb-3">
    <a href="{{ route('mensajes') }}" class="text-muted small">← Volver a mensajes</a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm p-4" style="border-radius: 14px;">

            <div class="d-flex align-items-center gap-3 mb-4">
                <div style="width: 44px; height: 44px; border-radius: 50%;
                            background: #e9ecef; display: flex; align-items: center;
                            justify-content: center; font-size: 20px;">
                    ✂️
                </div>
                <div>
                    <h5 class="mb-0">{{ $centro->nombre }}</h5>
                    @if($centro->direccion)
                        <p class="text-muted small mb-0">{{ $centro->direccion }}</p>
                    @endif
                </div>
            </div>

            @livewire('chat', ['centroId' => $centro->id, 'usuarioId' => $usuarioId])

        </div>
    </div>
</div>

@endsection
