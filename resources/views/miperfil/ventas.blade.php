@extends('miperfil.edit')

@section('content')
    <h1>Mis Ventas</h1>
    <ul>
        @foreach($ventas as $venta)
            <li>{{ $venta->car->marca }} {{ $venta->car->modelo }} - Vendido a: {{ $venta->buyer->name }}</li>
        @endforeach
    </ul>
@endsection
