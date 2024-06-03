@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content mt-5">
        <h1 class="text-center">{{ $car->marca }} {{ $car->modelo }}</h1>
        <div class="card mx-auto" style="width: 24rem;">
            @if ($car->imagen)
                <img src="{{ asset('storage/' . $car->imagen) }}" class="card-img-top" alt="{{ $car->marca }} {{ $car->modelo }}" onclick="openGallery(1)">
            @endif
            <div class="card-body">
                <h5 class="card-title">
                    <span>{{ $car->marca }} {{ $car->modelo }}</span>
                    <button class="btn-like{{ $isFavorite ? ' liked' : '' }}" onclick="toggleLike(this)" title="Guardar como favorito" data-car-id="{{ $car->id }}">
                        <i class="{{ $isFavorite ? 'fa-solid' : 'far' }} fa-heart"></i>
                    </button>
                </h5>
                <p class="card-text">
                    Año: {{ $car->anio }}<br>
                    Kilometraje: {{ $car->kilometraje }} km<br>
                    Precio: {{ number_format($car->precio, 2) }}€<br>
                    Color: {{ $car->color }}<br>
                    Distintivo Ambiental: {{ $car->distintivo_ambiental }}<br>
                    Combustible: {{ $car->combustible }}<br>
                    Transmisión: {{ $car->cambio }}<br>
                    Motor: {{ $car->motor }}<br>
                    Descripción: {{ $car->descripcion }}
                </p>
                <div class="mt-4">
               <hr>
              @if( $us->profile_image)
                <img src="{{ asset('storage/' . $us->profile_image) }}" alt="Foto de perfil" class="profile-image">
              @else
                 <img src="{{ asset('images/default_profile.png') }}" alt="Foto de perfil" class="profile-image">
              @endif
                {{ $us->username }}
            
                    @if(auth()->check())
                         @if(auth()->user()->profile == 'cliente')
                        <a href="{{ route('miperfil.chat', $car->id) }}" class="btn btn-success" id="chat-btn">Chatear</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-success">Iniciar sesión para chatear</a>
                    @endif 
                    @if(auth()->check())
                                @if(auth()->user()->profile == 'admin')
                            <div class="mt-3">
                                    <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-primary">Editar</a>
                                    <form action="{{ route('cars.destroy', $car->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este coche?')">Eliminar</button>
                                    </form>
                                </div>
                                 @endif
                     @endif
                </div>
            </div>
        </div>
        <!-- Código para la galería de imágenes -->
        <div class="mt-4">
            <div id="gallery-modal" class="gallery-modal">
                <span class="close" onclick="closeGallery()">&times;</span>
                <div class="gallery-content">
                    <img src="{{ asset('storage/' . $car->imagen) }}" class="gallery-slide"> <!-- Principal image -->
                    @foreach($car->images as $index => $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="gallery-slide" onclick="openGallery({{ $index + 2 }})">
                    @endforeach
                </div>
                <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
                <a class="next" onclick="changeSlide(1)">&#10095;</a>
            </div>
        </div>
    </div>
</div>

<style>
.card-title span {
    font-size: 35px;
}

.gallery-modal {
    display: none;
    position: fixed;
    z-index: 1000;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.9);
}

.gallery-content {
    position: relative;
    margin: auto;
    padding: 10px;
    width: 80%;
    max-width: 700px;
}

.gallery-slide {
    display: none;
    width: 100%;
}

.close {
    position: absolute;
    top: 20px;
    right: 35px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

.prev,
.next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    padding: 16px;
    margin-top: -22px;
    color: white;
    font-weight: bold;
    font-size: 20px;
    transition: 0.3s;
}

.prev {
    left: 0;
}

.next {
    right: 0;
}

.prev:hover,
.next:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

.btn-like {
    background: none;
    border: none;
    float: right;
    font-size: 1.3em;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}

.btn-like:hover {
    color: red;
}

.btn-like.liked {
    color: red;
}

.btn-like:focus {
    outline: none;
}
</style>

<script>
let slideIndex = 1;

function openGallery(n) {
    document.getElementById('gallery-modal').style.display = 'block';
    showSlides((slideIndex = n));
}

function closeGallery() {
    document.getElementById('gallery-modal').style.display = 'none';
}

function changeSlide(n) {
    showSlides((slideIndex += n));
}

function showSlides(n) {
    let slides = document.getElementsByClassName('gallery-slide');
    if (n > slides.length) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = slides.length;
    }
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';
    }
    slides[slideIndex - 1].style.display = 'block';
}

window.onclick  = function (event) {
    if (event.target == document.getElementById('gallery-modal')) {
        closeGallery();
    }
}

function toggleLike(button) {
    event.preventDefault();
    button.classList.toggle('liked');
    let icon = button.querySelector('i');
    let carId = button.getAttribute('data-car-id'); // Obtén el ID del coche desde el atributo data-car-id
    if (button.classList.contains('liked')) {
        icon.classList.remove('far', 'fa-heart');
        icon.classList.add('fa-solid', 'fa-heart');
        // Enviar solicitud AJAX para guardar el coche como favorito
        fetch('/coches-favoritos/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ car_id: carId })
        })
        .then(response => response.json())
        .then(data => {
            // Manejar la respuesta si es necesario
            console.log(data);
        });
    } else {
        icon.classList.remove('fa-solid', 'fa-heart');
        icon.classList.add('far', 'fa-heart');
        // Enviar solicitud AJAX para eliminar el coche de favoritos
        fetch(`/coches-favoritos/${carId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            // Manejar la respuesta si es necesario
            console.log(data);
        });
    }
}
</script>
@endsection
