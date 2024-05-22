@extends('miperfil.edit')

@section('content')
    <h1>Mis Favoritos</h1>
    <ul>
        @foreach($favoritos as $favorito)
            <li>{{ $favorito->car->marca }} {{ $favorito->car->modelo }} - Precio: {{ $favorito->car->precio }}</li>
        @endforeach
    </ul>
@endsection
