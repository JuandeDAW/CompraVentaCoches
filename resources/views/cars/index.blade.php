@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content mt-5">
        <h1 class="text-center">Coches Disponibles</h1>
        <form action="{{ route('cars.search') }}" method="GET" class="form-inline mb-3">
            <input class="form-control mr-sm-2" type="search" name="query" placeholder="Buscar coches" aria-label="Buscar">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
        <div class="row">
            @foreach($cars as $car)
                <div class="col-md-4">
                    <div class="card car-card" data-id="{{ $car->id }}">
                        @if ($car->imagen)
                        <img src="{{ asset('storage/' . $car->imagen) }}" class="card-img-top" alt="{{ $car->marca }} {{ $car->modelo }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $car->marca }} {{ $car->modelo }}</h5>
                            <p class="card-text">
                                Año: {{ $car->anio }}<br>
                                Kilometraje: {{ $car->kilometraje }} km<br>
                                Precio: ${{ number_format($car->precio, 2) }}<br>
                                Color: {{ $car->color }}<br>
                                Combustible: {{ $car->combustible }}<br>
                                Cambio: {{ $car->cambio }}<br>
                                Motor: {{ $car->motor }}
                            </p>
                            <a href="{{ route('cars.show', $car->id) }}" class="btn btn-primary">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

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
@endsection
