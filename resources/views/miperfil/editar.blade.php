@extends('miperfil.edit')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Editar Perfil</h1>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('miperfil.actualizar', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control form-control-sm" value="{{ auth()->user()->name }}" required>
            </div>

            <div class="col-md-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control form-control-sm" value="{{ auth()->user()->email }}" required>
            </div>

            <div class="col-md-4">
                <label for="username" class="form-label">Nombre de Usuario</label>
                <input type="text" name="username" class="form-control form-control-sm" value="{{ auth()->user()->username }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="password" class="form-label">Nueva Contraseña</label>
                <input type="password" name="password" class="form-control form-control-sm">
            </div>

            <div class="col-md-4">
                <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control form-control-sm">
            </div>
        </div>

        <div class="mb-3">
            <label for="profile_image" class="form-label">Foto de Perfil</label>
            <input type="file" name="profile_image" id="profile_image" class="form-control form-control-sm">
        </div>

        <button type="submit" class="btn btn-primary btn-sm">Guardar Cambios</button>
    </form>
</div>
@endsection
