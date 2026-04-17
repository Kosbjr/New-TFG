@extends('layouts.app')

@section('title', 'Home')

@section('content')

<h2>BIENVENID@</h2>

@if($modo === 'cliente')
    <p>Centros recomendados:</p>

    <div class="row">
        @foreach($centros as $centro)
            <div class="col-md-4">
                <div class="card p-3 mb-3">
                    {{ $centro->nombre }}
                </div>
            </div>
        @endforeach
    </div>
@else
    <h3>Panel del centro</h3>
@endif

@endsection
