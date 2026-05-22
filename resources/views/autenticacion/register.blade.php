@extends('layouts.app')

@section('main-class', 'd-flex justify-content-center align-items-center min-vh-100')

@section('content')

<div class="w-100" style="max-width: 420px;">

    <div class="bg-white rounded-2xl shadow-xl p-6">

        <h2 class="text-center mb-4">Registro</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="d-flex flex-column gap-3">
            @csrf

            <input class="form-control" name="nombre" placeholder="Nombre">
            <input class="form-control" name="email" placeholder="Email">
            <input class="form-control" name="telefono" placeholder="Teléfono">
            <input class="form-control" type="password" name="password" placeholder="Contraseña">
            <input class="form-control" type="password" name="password_confirmation" placeholder="Repetir contraseña">

            <select class="form-control" name="rol">
                <option value="cliente">Cliente</option>
                <option value="centro">Centro</option>
            </select>

            <button class="btn btn-primary w-100">
                Registrarse
            </button>
        </form>

    </div>

</div>

@endsection
