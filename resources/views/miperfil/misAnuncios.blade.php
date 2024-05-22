@extends('miperfil.edit')

@section('content')
    <div class="container">
        <div class="content mt-5">
            <h1>Mis Anuncios</h1>
            <div class="row">
                @foreach($cars as $car)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                @if ($car->imagen)
                                    <img src="{{ asset('storage/' . $car->imagen) }}" class="card-img-top" alt="{{ $car->marca }} {{ $car->modelo }}" onclick="openGallery({{ $loop->index + 1 }})">
                                @endif
                                <h5 class="card-title">{{ $car->marca }} {{ $car->modelo }}</h5>
                                <p class="card-text">
                                    Año: {{ $car->anio }}<br>
                                    Kilometraje: {{ $car->kilometraje }} km<br>
                                    Precio: {{ number_format($car->precio, 2) }}€<br>
                                    Color: {{ $car->color }}<br>
                                    Distintivo Ambiental: {{ $car->distintivo_ambiental }}<br>
                                    Combustible: {{ $car->combustible }}<br>
                                    Transmisión: {{ $car->cambio }}<br>
                                    Motor: {{ $car->motor }}
                                </p>
                                <div class="mt-3">
                                    <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-primary">Editar</a>
                                    <form action="{{ route('cars.destroy', $car->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este coche?')">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="gallery-modal" class="gallery-modal">
        <span class="close" onclick="closeGallery()">&times;</span>
        <div class="gallery-content">
            @foreach($cars as $index => $car)
                @if ($car->imagen)
                    <div class="gallery-slide">
                        <img src="{{ asset('storage/' . $car->imagen) }}" class="gallery-img" alt="{{ $car->marca }} {{ $car->modelo }}">
                    </div>
                @endif
                @foreach($car->images as $image)
                    <div class="gallery-slide">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="gallery-img" alt="{{ $car->marca }} {{ $car->modelo }}">
                    </div>
                @endforeach
            @endforeach
        </div>
        <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
        <a class="next" onclick="changeSlide(1)">&#10095;</a>
    </div>

    <style>
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
        text-align: center;
    }

    .gallery-img {
        width: 100%;
        height: auto;
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

    .prev, .next {
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

    .prev:hover, .next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }
    </style>

    <script>
    let slideIndex = 1;

    function openGallery(n) {
        document.getElementById('gallery-modal').style.display = 'block';
        showSlides(slideIndex = n);
    }

    function closeGallery() {
        document.getElementById('gallery-modal').style.display = 'none';
    }

    function changeSlide(n) {
        showSlides(slideIndex += n);
    }

    function showSlides(n) {
        let slides = document.getElementsByClassName('gallery-slide');
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = 'none';
        }
        slides[slideIndex - 1].style.display = 'block';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('gallery-modal')) {
            closeGallery();
        }
    }
    </script>
@endsection
