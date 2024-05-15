@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Vender Tu Coche</h1>

    <form action="{{ route('cars.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="marca">Marca</label>
            <input type="text" class="form-control" id="marca" name="marca" required>
        </div>
        <div class="form-group">
            <label for="modelo">Modelo</label>
            <input type="text" class="form-control" id="modelo" name="modelo" required>
        </div>
        <div class="form-group">
            <label for="color">Color</label>
            <input type="text" class="form-control" id="color" name="color" required>
        </div>
        <div class="form-group">
            <label for="anio">Año</label>
            <input type="number" class="form-control" id="anio" name="anio" required>
        </div>
        <div class="form-group">
            <label for="kilometraje">Kilometraje</label>
            <input type="number" class="form-control" id="kilometraje" name="kilometraje" required>
        </div>
        <div class="form-group">
            <label for="combustible">Combustible</label>
            <input type="text" class="form-control" id="combustible" name="combustible" required>
        </div>
        <div class="form-group">
            <label for="cambio">Cambio</label>
            <input type="text" class="form-control" id="cambio" name="cambio" required>
        </div>
        <div class="form-group">
            <label for="motor">Motor</label>
            <input type="text" class="form-control" id="motor" name="motor" required>
        </div>
        <div class="form-group">
            <label for="precio">Precio</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
        </div>
        <div class="form-group">
            <label for="image">Imagen del Coche</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Agregar Coche</button>
    </form>
</div>
@endsection
