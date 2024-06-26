@extends('miperfil.edit')

@section('content')
<div class="container">
    <h1>Mis Chats</h1>
    <div class="list-group">
        @forelse($messages as $carId => $carMessages)
            @php
                $car = $carMessages->first()->car;
                $lastMessage = $carMessages->last();
                $carOwner = $car->user->username;  // Assuming that the Car model has a relationship 'user' that returns the owner of the car
            @endphp
            <a href="{{ route('miperfil.chat', $carId) }}" class="list-group-item list-group-item-action">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('storage/' . $car->imagen) }}" alt="{{ $car->marca }} {{ $car->modelo }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                    <div class="ml-3">
                        <h5 class="mb-1">{{ $car->marca }} {{ $car->modelo }} - {{ $carOwner }}</h5>
                        <small>{{ $lastMessage->sender->username }}: {{ Str::limit($lastMessage->message, 30) }}</small>
                    </div>
                </div>
            </a>
        @empty        
                    <table>
                     <tr>    
                         <th><h4 >Todavia no tienes chats!</h4></th>
                     </tr>
                    <tr>
                        <td><img src="{{ asset('images/cara-triste2.jpg') }}" alt="Emoji" width="150px" class="emoji"></td>
                    </tr>
                     <tr>
                         <td><a href="{{ url('/') }}" class="boton-empty">Buscar Vehiculos</a></td>
                    </tr>
                    </table>
        @endforelse
    </div>
</div>
@endsection
