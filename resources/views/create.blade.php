@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content mt-5">
        <h1 class="text-center">Subir un Nuevo Coche</h1>
        <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            <div class="row">
                <div class="col-md-6">
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
                        <label for="distintivo_ambiental">Distintivo Ambiental</label>
                        <select class="form-control" id="distintivo_ambiental" name="distintivo_ambiental" required>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="ECO">ECO</option>
                            <option value="0">0</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="combustible">Combustible</label>
                        <select class="form-control" id="combustible" name="combustible" required>
                            <option value="Gasolina">Gasolina</option>
                            <option value="Diésel">Diésel</option>
                            <option value="Eléctrico">Eléctrico</option>
                            <option value="Híbrido">Híbrido</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cambio">Transmisión</label>
                        <select class="form-control" id="cambio" name="cambio" required>
                            <option value="Manual">Manual</option>
                            <option value="Automático">Automática</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="motor">Motor</label>
                        <input type="text" class="form-control" id="motor" name="motor" required>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio (€)</label>
                        <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                    </div>
                    <div class="form-group">
                        <label for="imagen_principal">Imagen Principal</label>
                        <input type="file" class="form-control-file" id="imagen_principal" name="imagen_principal" required>
                    </div>
                    <div class="form-group">
                        <label for="imagenes_adicionales">Imágenes Adicionales</label>
                        <input type="file" class="form-control-file" id="imagenes_adicionales" name="imagenes_adicionales[]" multiple>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" maxlength="1000"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Subir Coche</button>
        </form>
    </div>
</div>
@endsection
