@extends('miperfil.edit')

@section('content')
<div class="container">
    <div class="content mt-5">
        <h1 class="text-center">Mis Favoritos</h1>
        <div class="row">
            @foreach($favoritos as $favorito)
                <div class="col-md-4">
                    <div class="card car-card" data-id="{{ $favorito->car->id }}">
                        @if ($favorito->car->imagen)
                            <img src="{{ asset('storage/' . $favorito->car->imagen) }}" class="card-img-top car-main-img" alt="{{ $favorito->car->marca }} {{ $favorito->car->modelo }}">
                        @endif
                        <div class="card-body">
                            <h3 class="card-title">{{ $favorito->car->marca }} {{ $favorito->car->modelo }}</h3>
                            <h4>{{ number_format($favorito->car->precio) }}€</h4>
                            <p class="card-text">
                                Año: {{ $favorito->car->anio }}<br>
                                Kilometraje: {{ $favorito->car->kilometraje }} km<br>
                            </p>
                            <a href="{{ route('cars.show', $favorito->car->id) }}" class="btn btn-primary">Ver Detalles</a>
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
