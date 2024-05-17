@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content mt-5">
        <h1 class="text-center">{{ $car->marca }} {{ $car->modelo }}</h1>
        <div class="card mx-auto" style="width: 24rem;">
            @if ($car->imagen)
                <img src="{{ asset('storage/' . $car->imagen) }}" class="card-img-top" alt="{{ $car->marca }} {{ $car->modelo }}">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $car->marca }} {{ $car->modelo }}</h5>
                <p class="card-text">
                    Año: {{ $car->anio }}<br>
                    Kilometraje: {{ $car->kilometraje }} km<br>
                    Precio: {{ number_format($car->precio, 2) }}€<br>
                    Color: {{ $car->color }}<br>
                    Distintivo Ambiental: {{ $car->distintivo_ambiental }}<br>
                    Combustible: {{ $car->combustible }}<br>
                    Transmisión: {{ $car->cambio }}<br>
                    Motor: {{ $car->motor }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
