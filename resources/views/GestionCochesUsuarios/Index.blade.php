@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
  
<head>
<link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}">


    

    </style>
</head>
<body>
  <div class="main-cars">
    <h1  id="name">Anuncios de {{ $us->username}}</h1>

    @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="tabla" boord>
            <thead>
                <tr id="cabecera">
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Color</th>
                    <th>Imagen</th>
                    <th>año</th>
                    <th>Kilometraje</th>
                    <th>Distintivo ambiental</th>
                    <th>Combustible</th>
                    <th>Cambio</th>
                    <th>Motor</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

               
                @forelse ($cars as $car)
                    <tr>
                        <td>{{ $car->marca }}</td>
                        <td>{{ $car->modelo }}</td>
                        <td>{{ $car->color }}</td>
                        <td>{{ $car->imagen }}</td>
                        <td>{{ $car->anio }}</td>
                        <td>{{ $car->kilometraje}}</td>
                        <td>{{ $car->distintivo_ambiental }}</td>
                        <td>{{ $car->combustible }}</td>
                        <td>{{ $car->cambio}}</td>
                        <td>{{ $car->motor }}</td>
                        <td>{{ $car->precio }}</td>
                    
                        <td>
                            <a href="{{ route('cars.show', $car->id) }}" class="anuncio">Ver anuncio</a>
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="12">Este usuario no tiene Vehiculos publicados</td>
                </tr>
                @endforelse
                
                
            </tbody>
        </table>
    </div>
</body>
    @endsection
