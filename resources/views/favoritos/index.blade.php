@extends('layouts.app')
@section('title', 'Mis favoritos')
@section('content')

<h2 class="mb-4">Mis favoritos</h2>

<div class="row g-4">
    @forelse($favoritos as $fav)
        @php $centro = $fav->centro; @endphp
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('centro.show', $centro->id) }}" class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm border-0"
                     style="border-radius: 12px; overflow: hidden; transition: transform 0.2s;"
                     onmouseover="this.style.transform='translateY(-4px)'"
                     onmouseout="this.style.transform='translateY(0)'">

                    <div style="height: 200px; overflow: hidden; background: #f0f0f0;">
                        @php $foto = $centro->fotos->first(); @endphp
                        @if($foto)
                            <img src="{{ asset('storage/' . $foto->ruta) }}"
                                 alt="{{ $centro->nombre }}"
                                 style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                <i class="bi bi-scissors" style="font-size:48px;"></i>
                            </div>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h5 class="card-title mb-1">{{ $centro->nombre }}</h5>
                            <form action="{{ route('favoritos.toggle', $centro->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm p-0 border-0 bg-transparent"
                                        title="Quitar de favoritos">
                                    <i class="bi bi-heart-fill text-danger" style="font-size:18px;"></i>
                                </button>
                            </form>
                        </div>

                        @if($centro->direccion)
                            <p class="text-muted small mb-2">
                                <i class="bi bi-geo-alt"></i> {{ $centro->direccion }}
                            </p>
                        @endif

                        @if($centro->categorias->count())
                            <div class="d-flex flex-wrap gap-1 mt-2">
                                @foreach($centro->categorias as $cat)
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
    @empty
        <div class="col-12">
            <p class="text-muted">Aún no tienes centros favoritos.</p>
            <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm">
                Explorar centros
            </a>
        </div>
    @endforelse
</div>

@endsection
