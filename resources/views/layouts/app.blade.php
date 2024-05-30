<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Wallacar') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}">
  
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <style>
   
        .navbar-nav .nav-item .nav-link {
            color: black;
        }
        .navbar-nav .nav-item .nav-link:hover {
            color: red;
        }
        .navbar-nav .nav-item .btn {
            color: #fff;
            margin-left:10px
        }
        .car-card img {
            height: 200px;
            object-fit: cover;
        }
        .form-control {
            height: 38px; 
            padding: 9px 18px; 
            font-size: 16px; 
            line-height: 24px; 
            border-radius: 4px; 
}

        .form-control-file {
            height: 38px; 
            padding: 9px 18px; 
            font-size: 16px; 
            line-height: 24px; 
            border-radius: 4px; 
        }
        .navbar-brand img {
            height: 140px; 
            width: auto; 
            margin:0% auto;
            
        }
        .navbar {
        margin-bottom: 0; 
        padding-bottom: 0; 
    }
    .bg-custom{
       padding-top:30px
    }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
            
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <form class="form-inline my-2 my-lg-0" method="GET" action="{{ route('cars.search') }}">
                            <input class="form-control mr-sm-2" type="search" placeholder="Buscar coches" aria-label="Buscar" name="query">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                        </form>
                    </ul>
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                             <a class="navbar-brand" href="{{ url('/') }}">
                                <img src="{{ asset('images/WALLACAR_REC.png') }}" alt="Logo" > 
                             </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                            </li>
                        @else
                            @if(auth()->user()->profile == 'admin')
                            <li class="nav-item">
                                 <a class="nav-link" href="{{ route('statistics.index')}}">Estadisticas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('usuarios.index') }}">Gestión Usuarios</a>
                            </li>

                            @endif
                            @if(auth()->user()->profile == 'cliente')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('miperfil.misAnuncios') }}">Mi Perfil</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary" href="{{ route('create') }}">Subir Coche</a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="bg-custom">
            @yield('content')
        </main>

        <footer class="footer mt-auto py-3 bg-light">
            <div class="container text-center">
                <span class="text-muted">© {{ date('Y') }} Wallacar. Todos los derechos reservados.</span>
            </div>
        </footer>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
