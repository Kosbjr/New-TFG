@extends('layouts.app')
@section('title', 'Login')

@section('main-class', 'd-flex justify-content-center align-items-center min-vh-100')

@section('content')

<style>
    body {
        background-color: #1abc9c;
        margin: 0;
    }

    .card-custom {
        background-color: white;
        padding: 30px;
        border-radius: 12px;
        width: 100%;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);
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
        margin-top: 10px;
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 6px;
        background-color: #1abc9c;
        color: white;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-turquesa:hover {
        background-color: #16a085;
    }

    .link-auth {
        color: #1abc9c;
        text-decoration: none;
        font-weight: 500;
    }

    .link-auth:hover {
        text-decoration: underline;
    }

    .alert-error {
        background-color: #ffdddd;
        color: #b30000;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 15px;
    }
</style>

<div class="w-100" style="max-width: 420px;">

    <div class="card-custom">

        <h2 class="title-auth">Iniciar Sesión</h2>

        <hr>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="d-flex flex-column gap-3">
            @csrf

            <input type="email"
                   name="email"
                   placeholder="Email"
                   class="input-custom">

            <input type="password"
                   name="password"
                   placeholder="Contraseña"
                   class="input-custom">

            <button class="btn-turquesa">
                Entrar
            </button>
        </form>

        <p class="text-center mt-4 mb-0">
            <a href="{{ route('register') }}" class="link-auth">
                Crear cuenta
            </a>
        </p>

    </div>

</div>

@endsection
