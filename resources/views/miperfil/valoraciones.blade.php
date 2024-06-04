@extends('miperfil.edit')

@section('content')
    <h1>Mis Valoraciones</h1>
    <ul>
        @forelse($valoraciones as $valoracion)
            <li>Valoración: {{ $valoracion->comentario }}</li>
            @empty
                   
           <li>    
              <th><h4 >Todavia no tienes anuncios!</h4></th>
             </li>
             <li>
              <img src="{{ asset('images/cara-triste2.jpg') }}" alt="Emoji" width="150px" class="emoji">
            </li>
                    
                @endforelse
    </ul>
@endsection
