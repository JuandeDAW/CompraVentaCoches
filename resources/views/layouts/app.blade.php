<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra y Venta de Coches</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Enlace a tu archivo CSS generado por Laravel Mix -->
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Compra y Venta de Coches</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cars.index') }}">Coches Disponibles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cars.create') }}">Vender Tu Coche</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="footer mt-5 py-4 bg-dark text-white">
        <div class="container text-center">
            <span>&copy; {{ date('Y') }} Compra y Venta de Coches</span>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Enlace a tu archivo JavaScript generado por Laravel Mix -->
</body>
</html>
