@extends('miperfil.edit')

@section('content')
    <h1>Mis Chats</h1>
    <ul>
        @foreach($chats as $chat)
            <li>Chat con: {{ $chat->nombre_usuario }}</li>
        @endforeach
    </ul>
@endsection
