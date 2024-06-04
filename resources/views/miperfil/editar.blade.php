@extends('miperfil.edit')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Editar Perfil</h1>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <form action="{{ route('miperfil.actualizar', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
        </div>
        <div class="form-group">
            <label for="username">Nombre de Usuario</label>
            <input type="text" name="username" class="form-control" value="{{ auth()->user()->username }}" required>
        </div>
        <div class="form-group">
        <label for="profile_image">Foto de Perfil</label> <br>
         <input type="file" name="profile_image" id="profile_image">
         </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
@endsection
