<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>@yield('title')</title>
</head>

<body class="bg-light">

<nav class="p-3 bg-white shadow-sm d-flex justify-content-between">
    <h4>Mi App</h4>

    <div>
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-outline-primary">Registro</a>
    </div>
</nav>

<main class="container py-5">
    @yield('content')
</main>

</body>
</html>
