@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="mt-5 mb-4">¡Bienvenido a nuestra plataforma de compra y venta de coches!</h1>
            <p class="lead">Encuentra el coche perfecto para ti o vende el tuyo de manera rápida y sencilla.</p>
            <a href="{{ route('cars.index') }}" class="btn btn-primary btn-lg mr-3">Ver Coches Disponibles</a>
            <a href="{{ route('cars.create') }}" class="btn btn-success btn-lg">Vender Tu Coche</a>
        </div>
    </div>
</div>
@endsection
