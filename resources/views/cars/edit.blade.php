@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Editar Coche</h1>
    <form action="{{ route('cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="marca">Marca</label>
                    <input type="text" class="form-control" id="marca" name="marca" value="{{ $car->marca }}">
                </div>
                <div class="form-group">
                    <label for="modelo">Modelo</label>
                    <input type="text" class="form-control" id="modelo" name="modelo" value="{{ $car->modelo }}">
                </div>
                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="text" class="form-control" id="color" name="color" value="{{ $car->color }}">
                </div>
                <div class="form-group">
                    <label for="anio">Año</label>
                    <input type="number" class="form-control" id="anio" name="anio" value="{{ $car->anio }}">
                </div>
                <div class="form-group">
                    <label for="kilometraje">Kilometraje</label>
                    <input type="number" class="form-control" id="kilometraje" name="kilometraje" value="{{ $car->kilometraje }}">
                </div>
                <div class="form-group">
                    <label for="distintivo_ambiental">Distintivo Ambiental</label>
                    <select class="form-control" id="distintivo_ambiental" name="distintivo_ambiental" required>
                        <option value="B" {{ $car->distintivo_ambiental == 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ $car->distintivo_ambiental == 'C' ? 'selected' : '' }}>C</option>
                        <option value="ECO" {{ $car->distintivo_ambiental == 'ECO' ? 'selected' : '' }}>ECO</option>
                        <option value="0" {{ $car->distintivo_ambiental == '0' ? 'selected' : '' }}>0</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="combustible">Combustible</label>
                    <select class="form-control" id="combustible" name="combustible" required>
                        <option value="Gasolina" {{ $car->combustible == 'Gasolina' ? 'selected' : '' }}>Gasolina</option>
                        <option value="Diésel" {{ $car->combustible == 'Diésel' ? 'selected' : '' }}>Diésel</option>
                        <option value="Eléctrico" {{ $car->combustible == 'Eléctrico' ? 'selected' : '' }}>Eléctrico</option>
                        <option value="Híbrido" {{ $car->combustible == 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cambio">Transmisión</label>
                    <select class="form-control" id="cambio" name="cambio" required>
                        <option value="Manual" {{ $car->cambio == 'Manual' ? 'selected' : '' }}>Manual</option>
                        <option value="Automático" {{ $car->cambio == 'Automático' ? 'selected' : '' }}>Automático</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="motor">Motor</label>
                    <input type="text" class="form-control" id="motor" name="motor" value="{{ $car->motor }}">
                </div>
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" class="form-control" id="precio" name="precio" value="{{ $car->precio }}">
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" maxlength="1000">{{ $car->descripcion }}</textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="imagen">Imagen Principal</label>
            <input type="file" class="form-control-file" id="imagen" name="imagen">
            @if($car->imagen)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $car->imagen) }}" class="img-thumbnail" style="width: 150px;">
                </div>
            @endif
        </div>
        <div class="form-group">
            <label for="imagenes">Imágenes Adicionales (máximo 10)</label>
            <input type="file" class="form-control-file" id="imagenes" name="imagenes[]" multiple>
        </div>
        <div class="form-group">
            <label>Imágenes Actuales</label>
            <div class="row">
                @foreach($car->images as $image)
                    <div class="col-md-2 mb-3">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail">
                        <button type="button" class="btn btn-danger btn-sm btn-block mt-2 remove-image" data-image-id="{{ $image->id }}">Eliminar</button>
                        <input type="hidden" name="remove_images[]" value="" class="remove-images-input">
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.remove-image').forEach(button => {
        button.addEventListener('click', function() {
            const imageId = this.getAttribute('data-image-id');
            this.nextElementSibling.value = imageId;
            this.parentElement.style.display = 'none';
        });
    });
});
</script>
@endsection
