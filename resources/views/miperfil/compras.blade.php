@extends('miperfil.edit')

@section('content')
    <h1>Mis Compras</h1>
    <ul>
        @foreach($compras as $compra)
            <li>{{ $compra->car->marca }} {{ $compra->car->modelo }} - Comprado a: {{ $compra->seller->name }}</li>
        @endforeach
    </ul>
@endsection
