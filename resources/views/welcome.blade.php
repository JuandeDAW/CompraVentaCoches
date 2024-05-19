<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Compra y Venta de Coches</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin-top: 20px;
            cursor: pointer;
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ url('/') }}">Coches</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                @if (Route::has('login'))
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/index') }}">Inicio</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                            </li>
                        @endif
                    @endauth
                @endif
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="content mt-5">
            <h1 class="text-center">Coches Disponibles</h1>
            <div class="row">
                @foreach($cars as $car)
                    <div class="col-md-4">
                        <div class="card car-card" data-id="{{ $car->id }}">
                            @if ($car->image)
                            <img src="{{ $car->imagen }}" class="card-img-top" alt="{{ $car->marca }} {{ $car->modelo }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $car->marca }} {{ $car->modelo }}</h5>
                                <p class="card-text">
                                    Año: {{ $car->anio }}<br>
                                    Kilometraje: {{ $car->kilometraje }} km<br>
                                    Precio: {{ number_format($car->precio)€ }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.car-card').forEach(function (card) {
                card.addEventListener('click', function () {
                    var carId = this.getAttribute('data-id');
                    window.location.href = '/cars/' + carId;
                });
            });
        });
    </script>
</body>
</html>
