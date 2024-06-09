@extends('miperfil.edit')

@section('content')
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

.btn-valoracion {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        text-align: center;
        text-decoration: none;
        color: #fff;
        background-color: #007bff;
        border: 1px solid #007bff;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-valoracion:hover {
        background-color: #0056b3;
        color: #fff;
    }

    .badge-valoracion {
        padding: 5px 10px;
        font-size: 14px;
        font-weight: 500;
        color: #fff;
        background-color: #28a745;
        border-radius: 5px;
    }
</style>
<div class="container">
    <h1>Mis Compras</h1>
    <div class="row">
        @forelse($compras as $compra)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if ($compra->car->imagen)
                        <img src="{{ asset('storage/' . $compra->car->imagen) }}" class="card-img-top" alt="{{ $compra->car->marca }} {{ $compra->car->modelo }}" onclick="openGallery({{ $compra->car->id }}, 1)">
                    @endif
                    <div class="card-body">
                    <h5 class="card-title">{{ $compra->car->marca }} {{ $compra->car->modelo }}</h5>
                    <p class="card-text">
                            Año: {{ $compra->car->anio }}<br>
                            Kilometraje: {{ $compra->car->kilometraje }} km<br>
                            Precio: {{ number_format($compra->car->precio, 2) }}€<br>
                            Color: {{ $compra->car->color }}<br>
                            Distintivo Ambiental: {{ $compra->car->distintivo_ambiental }}<br>
                            Combustible: {{ $compra->car->combustible }}<br>
                            Transmisión: {{ $compra->car->cambio }}<br>
                            Motor: {{ $compra->car->motor }}<br>
                            Descripción: {{ $compra->car->descripcion }}<br>
                            @if ($compra->valoracion_dejada)
                            <span class="badge-valoracion">Valoración enviada con éxito</span>
                            @else
                            <a class="btn-valoracion" href="{{ route('valoraciones.create', $compra->id) }}">Dejar una valoración</a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <p>No has realizado ninguna compra aún.</p>
        @endforelse
    </div>

    @foreach($compras as $compra)
        <!-- Galería de imágenes para cada coche comprado -->
        <div id="gallery-modal-{{ $compra->car->id }}" class="gallery-modal">
            <span class="close" onclick="closeGallery({{ $compra->car->id }})">&times;</span>
            <div class="gallery-content">
                <img src="{{ asset('storage/' . $compra->car->imagen) }}" class="gallery-slide"> <!-- Imagen principal -->
                @foreach($compra->car->images as $index => $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="gallery-slide" onclick="openGallery({{ $compra->car->id }}, {{ $index + 2 }})">
                @endforeach
            </div>
            <a class="prev" onclick="changeSlide({{ $compra->car->id }}, -1)">&#10094;</a>
            <a class="next" onclick="changeSlide({{ $compra->car->id }}, 1)">&#10095;</a>
        </div>
    @endforeach
</div>

<script>
let slideIndex = {};

function openGallery(carId, n) {
    slideIndex[carId] = n;
    document.getElementById('gallery-modal-' + carId).style.display = 'block';
    showSlides(carId, n);
}

function closeGallery(carId) {
    document.getElementById('gallery-modal-' + carId).style.display = 'none';
}

function changeSlide(carId, n) {
    showSlides(carId, slideIndex[carId] += n);
}

function showSlides(carId, n) {
    let slides = document.querySelectorAll('#gallery-modal-' + carId + ' .gallery-slide');
    if (n > slides.length) { slideIndex[carId] = 1; }
    if (n < 1) { slideIndex[carId] = slides.length; }
    slides.forEach(slide => slide.style.display = 'none');
    slides[slideIndex[carId] - 1].style.display = 'block';
}

window.onclick = function(event) {
    if (event.target.classList.contains('gallery-modal')) {
        closeGallery(event.target.id.replace('gallery-modal-', ''));
    }
}
</script>
@endsection