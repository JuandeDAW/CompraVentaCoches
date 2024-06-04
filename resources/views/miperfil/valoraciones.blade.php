@extends('miperfil.edit')

@section('content')
    <h1>Mis Valoraciones</h1>
    <ul>
        @forelse($valoraciones as $valoracion)
            <li>Valoración: {{ $valoracion->comentario }}</li>
        @endforeach
    </ul>
@endsection
