@extends('miperfil.edit')

@section('content')

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
            background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente */
        }

        .gallery-modal.no-background {
            background-color: transparent; /* Eliminar el fondo para este modal */
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

        .modal-dialog {
            background-color: transparent !important; /* Fondo del modal transparente */
            box-shadow: none !important; /* Eliminar la sombra del modal */
        }
        
        .modal-backdrop {
            display: none; /* Ocultar el backdrop del modal */
        }
        .modal {
    display: none; /* Asegurarse de que el modal está oculto por defecto */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-dialog {
    position: relative;
    margin: auto;
    padding: 10px;
    width: 80%;
    max-width: 700px;
    background-color: #fff;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    animation-name: animatetop;
    animation-duration: 0.4s;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

    </style>

    <div class="container">
        <div class="content mt-5">
            <h1>Mis Anuncios</h1>
            <div class="row">
                @forelse($cars as $car)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                @if ($car->imagen)
                                    <img src="{{ asset('storage/' . $car->imagen) }}" class="card-img-top" alt="{{ $car->marca }} {{ $car->modelo }}" onclick="openGallery({{ $car->id }})">
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
                                    Motor: {{ $car->motor }}<br>
                                    Descripción: {{ $car->descripcion }}
                                </p>
                                <div class="mt-3">
                                    <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-primary">Editar</a>
                                    <form action="{{ route('cars.destroy', $car->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este coche?')">Eliminar</button>
                                    </form>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#sellCarModal" data-car-id="{{ $car->id }}" onclick="openSellModal({{ $car->id }})">Vender</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <table>
                        <tr>
                            <th><h4>Todavía no tienes anuncios!</h4></th>
                        </tr>
                        <tr>
                            <td><img src="{{ asset('images/cara-triste2.jpg') }}" alt="Emoji" width="150px" class="emoji"></td>
                        </tr>
                        <tr>
                            <td><a href="{{ url('/create') }}" class="boton-empty">Subir Coche</a></td>
                        </tr>
                    </table>
                @endforelse
            </div>
        </div>
    </div>

    <div id="gallery-modal" class="gallery-modal">
        <span class="close" onclick="closeGallery()">&times;</span>
        <div class="gallery-content" id="gallery-content">
            <!-- Las diapositivas se insertarán dinámicamente -->
        </div>
        <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
        <a class="next" onclick="changeSlide(1)">&#10095;</a>
    </div>
    
    <!-- Modal para Vender -->
<div class="modal" id="sellCarModal" tabindex="-1" role="dialog" aria-labelledby="sellCarModalLabel" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sellCarModalLabel">Seleccionar Comprador</h5>
                <button type="button" class="close" aria-label="Close" onclick="closeSellModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('cars.sell') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="car_id" id="car_id" value="">
                    <div class="form-group">
                        <label for="buyer_id">Seleccionar Comprador:</label>
                        <select name="buyer_id" id="buyer_id" class="form-control">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                            @endforeach
                            <option value="">Lo he vendido fuera de Wallacar</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeSellModal()">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Vender</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script>
        let slideIndex = 1;
        let carImages = @json($cars->mapWithKeys(function ($car){
            return [$car->id => [
                'main_image' => $car->imagen ? asset('storage/' . $car->imagen) : null,
                'additional_images' => $car->images->map(function ($image) {
                    return asset('storage/' . $image->image_path);
                })
            ]];
        }));

        function openGallery(carId) {
            const galleryContent = document.getElementById('gallery-content');
            galleryContent.innerHTML = ''; // Limpiar el contenido anterior

            const images = carImages[carId];
            if (images.main_image) {
                let mainImage = document.createElement('div');
                mainImage.classList.add('gallery-slide');
                mainImage.innerHTML = `<img src="${images.main_image}" class="gallery-img" alt="Imagen Principal">`;
                galleryContent.appendChild(mainImage);
            }

            images.additional_images.forEach(imagePath => {
                let additionalImage = document.createElement('div');
                additionalImage.classList.add('gallery-slide');
                additionalImage.innerHTML = `<img src="${imagePath}" class="gallery-img" alt="Imagen Adicional">`;
                galleryContent.appendChild(additionalImage);
            });

            document.getElementById('gallery-modal').className = 'gallery-modal'; // Restablecer la clase para eliminar cualquier clase adicional
            document.getElementById('gallery-modal').style.display = 'block';
            showSlides(slideIndex = 1);
        }

        function closeGallery() {
            document.getElementById('gallery-modal').style.display = 'none';
        }

        function changeSlide(n) {
            showSlides(slideIndex += n);
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName('gallery-slide');
            if (n > slides.length) { slideIndex = 1 }
            if (n < 1) { slideIndex = slides.length }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = 'none';
            }
            slides[slideIndex - 1].style.display = 'block';
        }

        function openSellModal(carId) {
        console.log('Car ID:', carId); // Verificar si carId está siendo capturado correctamente
        document.getElementById('car_id').value = carId; // Asignar el valor al input oculto en el modal
        document.getElementById('sellCarModal').style.display = 'block'; // Mostrar el modal (asumiendo que tienes algún estilo para mostrar el modal)
    }

    // Cerrar el modal al hacer clic en el botón de cerrar
    function closeSellModal() {
        document.getElementById('sellCarModal').style.display = 'none';
    }

    // Cerrar el modal si se hace clic fuera de él
    window.onclick = function(event) {
        var modal = document.getElementById('sellCarModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
    </script>
@endsection
