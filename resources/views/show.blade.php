@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        @if ($car->image)
            <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top" alt="{{ $car->marca }} {{ $car->modelo }}">
        @endif
        <div class="card-body">
            <h2 class="card-title">{{ $car->marca }} {{ $car->modelo }}</h2>
            <p class="card-text">
                Color: {{ $car->color }}<br>
                Año: {{ $car->anio }}<br>
                Kilometraje: {{ $car->kilometraje }} km<br>
                Combustible: {{ $car->combustible }}<br>
                Cambio: {{ $car->cambio }}<br>
                Motor: {{ $car->motor }}<br>
                Precio: ${{ number_format($car->precio, 2) }}
            </p>
            <a href="{{ url('/') }}" class="btn btn-primary">Volver</a>
        </div>
    </div>
</div>
@endsection
