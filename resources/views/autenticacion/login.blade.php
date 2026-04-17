@extends('layouts.app')

@section('content')

<div class="auth-wrapper">

    <div class="card-custom">

        <h2 class="title-auth">Iniciar Sesión</h2>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <input
                type="email"
                name="email"
                placeholder="Email"
                class="input-custom"
            >

            <input
                type="password"
                name="password"
                placeholder="Contraseña"
                class="input-custom"
            >

            <button class="btn-turquesa">
                Entrar
            </button>
        </form>

        <p class="text-center mt-4">
            <a href="{{ route('register') }}" class="link-auth">
                Crear cuenta
            </a>
        </p>

    </div>

</div>

@endsection
