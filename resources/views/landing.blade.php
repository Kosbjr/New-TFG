@extends('layouts.public')

@section('title', 'Bienvenido')

@section('content')

<div class="text-center mb-5">
    <h1>Mi App</h1>
    <p>Reserva citas, contacta centros y gestiona todo</p>
</div>

<hr>

<h3 class="mb-4">Funciones</h3>

<div class="row">

    <div class="col-md-4 mb-3">
        <div class="card p-3 text-center">
            <h5>Citas</h5>
            <a href="{{ auth()->check() ? route('citas') : route('login') }}">
                Acceder
            </a>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card p-3 text-center">
            <h5>Mensajes</h5>
            <a href="{{ auth()->check() ? route('mensajes') : route('login') }}">
                Acceder
            </a>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card p-3 text-center">
            <h5>Panel</h5>
            <a href="{{ auth()->check() ? route('home') : route('login') }}">
                Acceder
            </a>
        </div>
    </div>

</div>

@endsection
