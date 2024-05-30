@extends('layouts.app')

@section('content')

<div class="container">
<img src="{{ asset('images/Banner.png') }}" alt="banner" id="banner">
    <div class="sort-options">
            <div class="col-12">
                <form method="GET" action="{{ route('cars.sort') }}" class="form-inline">
                    <div class="form-group mr-2">
                        <label for="sort" class="mr-2">Ordenar por:</label>
                        <select name="sort" id="sort" class="form-control">
                            <option value="price_asc">Precio Ascendente</option>
                            <option value="price_desc">Precio Descendente</option>
                            <option value="date_asc">Fecha Ascendente</option>
                            <option value="date_desc">Fecha Descendente</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Ordenar</button>
                </form>
            </div>
        </div>
    <div class="content mt-5">
        <h1 class="text-center">Coches Disponibles</h1> <br>
        <div class="row">
            @foreach($cars as $car)
                <div class="col-md-4">
                    <div class="card car-card" data-id="{{ $car->id }}">
                        @if ($car->imagen)
                            <img src="{{ asset('storage/' . $car->imagen) }}" class="card-img-top car-main-img" alt="{{ $car->marca }} {{ $car->modelo }}">
                        @endif
                        <div class="card-body">
                            <h3 class="card-title">{{ $car->marca }} {{ $car->modelo }}</h3>
                            <h4 id="card-subtitle">{{ number_format($car->precio) }}€</h4>
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
        {{ $cars->links() }}
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
