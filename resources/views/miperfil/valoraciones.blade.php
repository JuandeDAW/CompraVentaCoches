@extends('miperfil.edit')

@section('content')
    <h1>Mis Valoraciones</h1>
    <ul>
        @foreach($valoraciones as $valoracion)
            <li>Valoración: {{ $valoracion->comentario }}</li>
        @endforeach
    </ul>
@endsection
