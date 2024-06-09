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

</style>

<div class="container">
    <h1>Mis Ventas</h1>
    <div class="row">
        @forelse($ventas as $venta)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if ($venta->car->imagen)
                        <img src="{{ asset('storage/' . $venta->car->imagen) }}" class="card-img-top" alt="{{ $venta->car->marca }} {{ $venta->car->modelo }}" onclick="openGallery({{ $venta->car->id }}, 1)">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $venta->car->marca }} {{ $venta->car->modelo }}</h5>
                        <p class="card-text">
                        Año: {{ $venta->car->anio }}<br>
                        Kilometraje: {{ $venta->car->kilometraje }} km<br>
                        Precio: {{ number_format($venta->car->precio, 2) }}€<br>
                        Color: {{ $venta->car->color }}<br>
                        Distintivo Ambiental: {{ $venta->car->distintivo_ambiental }}<br>
                        Combustible: {{ $venta->car->combustible }}<br>
                        Transmisión: {{ $venta->car->cambio }}<br>
                        Motor: {{ $venta->car->motor }}<br>
                        Descripción: {{ $venta->car->descripcion }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <p>No has realizado ninguna venta aún.</p>
        @endforelse
    </div>

    @foreach($ventas as $venta)
        <!-- Galería de imágenes para cada coche vendido -->
        <div id="gallery-modal-{{ $venta->car->id }}" class="gallery-modal">
            <span class="close" onclick="closeGallery({{ $venta->car->id }})">&times;</span>
            <div class="gallery-content">
                <img src="{{ asset('storage/' . $venta->car->imagen) }}" class="gallery-slide"> <!-- Imagen principal -->
                @foreach($venta->car->images as $index => $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" class="gallery-slide" onclick="openGallery({{ $venta->car->id }}, {{ $index + 2 }})">
                @endforeach
            </div>
            <a class="prev" onclick="changeSlide({{ $venta->car->id }}, -1)">&#10094;</a>
            <a class="next" onclick="changeSlide({{ $venta->car->id }}, 1)">&#10095;</a>
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