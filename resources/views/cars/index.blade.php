@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content mt-5">
        <h1 class="text-center">Coches Disponibles</h1>
        <div class="row">
            @foreach($cars as $car)
                <div class="col-md-4">
                    <div class="card car-card" data-id="{{ $car->id }}">
                        @if ($car->imagen)
                            <img src="{{ asset('storage/' . $car->imagen) }}" class="card-img-top car-main-img" alt="{{ $car->marca }} {{ $car->modelo }}">
                        @endif
                        <div class="card-body">
                            <h3 class="card-title">{{ $car->marca }} {{ $car->modelo }}</h3>
                            <h4>{{ number_format($car->precio) }}€</h4>
                            <p class="card-text">
                                Año: {{ $car->anio }}<br>
                                Kilometraje: {{ $car->kilometraje }} km<br>
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
