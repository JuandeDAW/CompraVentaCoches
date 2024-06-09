@extends('miperfil.edit')

@section('content')
    <div class="container">
        <h1 class="my-4">Mis Valoraciones</h1>
        <div class="list-group">
            @forelse($valoraciones as $valoracion)
                <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><strong>{{ $valoracion->buyer->username }}</strong></h5>
                        <small>Puntuación: {{ $valoracion->rating }}</small>
                    </div>
                    <p class="mb-1">{{ $valoracion->comentario }}</p>
                </div>
            @empty
                <div class="alert alert-info" role="alert">
                    Todavía no tienes valoraciones.
                </div>
            @endforelse
        </div>
    </div>
@endsection
