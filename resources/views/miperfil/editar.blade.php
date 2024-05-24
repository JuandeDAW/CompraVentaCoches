@extends('miperfil.edit')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Editar Perfil</h1>
    <form action="{{ route('profile.update', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ auth()->user()->name }}">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ auth()->user()->telefono }}">
        </div>
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ auth()->user()->direccion }}">
        </div>
        <div class="form-group">
            <label for="avatar">Avatar</label>
            <input type="file" class="form-control-file" id="avatar" name="avatar">
        </div>
        @if(auth()->user()->avatar)
            <div class="form-group">
                <label>Avatar Actual</label>
                <div>
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="img-thumbnail" style="width: 150px;">
                </div>
            </div>
        @endif
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
@endsection