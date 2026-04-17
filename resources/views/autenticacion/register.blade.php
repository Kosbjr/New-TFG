@extends('layouts.app')

@section('content')

<div class="auth-wrapper">

    <div class="card-custom">

        <h2 class="title-auth">Registro</h2>

        @if ($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-3">
            @csrf

            <input type="text" name="nombre" placeholder="Nombre" class="input-custom">

            <input type="email" name="email" placeholder="Email" class="input-custom">

            <input type="text" name="telefono" placeholder="Teléfono" class="input-custom">

            <input type="password" name="password" placeholder="Contraseña" class="input-custom">

            <input type="password" name="password_confirmation" placeholder="Repetir contraseña" class="input-custom">

            <select name="rol" class="input-custom">
                <option value="cliente">Cliente</option>
                <option value="centro">Centro</option>
            </select>

            <button class="btn-turquesa mt-2">
                Registrarse
            </button>
        </form>

        <p class="text-center mt-4">
            <a href="{{ route('login') }}" class="link-auth">
                Ya tengo cuenta
            </a>
        </p>

    </div>

</div>

@endsection
