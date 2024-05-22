@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Anuncios de </h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
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
            @foreach ($cars as $car)
                <tr>
                    <td>{{ $car->marca }}</td>
                    <td>{{ $car->modelo }}</td>
                    <td>{{ $car->color }}</td>
                    <td>{{ $car->imagen }}</td>
                    <td>{{ $car->anio }}</td>
                    <td>{{ $car->Kilometraje }}</td>
                    <td>{{ $car->distintivo_ambiental }}</td>
                    <td>{{ $car->combustible }}</td>
                    <td>{{ $car->cambio}}</td>
                    <td>{{ $car->motor }}</td>
                    <td>{{ $car->precio }}</td>
                  
                    <td>
                        <a href="" class="btn btn-primary">Ver anuncio</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
