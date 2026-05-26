@extends('layouts.app')

@section('main-class', 'd-flex justify-content-center align-items-center min-vh-100')

@section('content')

<style>
    body {
        background-color: #1abc9c;
    }

    .card-custom {
        background-color: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 0 15px rgba(0,0,0,0.15);
    }

    .title-auth {
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .input-custom {
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    .btn-turquesa {
        background-color: #1abc9c;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 6px;
        transition: 0.3s;
    }
    .link-auth {
        color: #1abc9c;
        text-decoration: none;
    }

    .btn-turquesa:hover {
        background-color: #16a085;
    }

    .alert-error {
        background-color: #ffe5e5;
        color: #c0392b;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 15px;
    }
</style>

<div class="w-100" style="max-width: 420px;">

    <div class="card-custom">

        <h2 class="title-auth">Registro</h2>
        <hr>
        @if ($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="d-flex flex-column gap-3">
            @csrf

            <input class="input-custom" name="nombre" placeholder="Nombre">

            <input class="input-custom" name="email" placeholder="Email">

            <input class="input-custom" name="telefono" placeholder="Teléfono">

            <input class="input-custom" type="password" name="password" placeholder="Contraseña">

            <input class="input-custom" type="password" name="password_confirmation"
                placeholder="Repetir contraseña">

            <select class="input-custom" name="rol">
                <option value="cliente">Cliente</option>
                <option value="centro">Centro</option>
            </select>

            <button class="btn-turquesa w-100">
                Registrarse
            </button>

        </form>
        <p class="text-center mt-4">
            <a href="{{ route('login') }}" class="link-auth">
                Iniciar sesión
            </a>
        </p>
    </div>

</div>

@endsection
