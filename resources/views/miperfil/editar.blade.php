@extends('miperfil.edit')

@section('content')
    <div class="container">
        <div class="content mt-5">
            <h1 class="mb-4">Editar Perfil</h1>
            <form method="POST" action="{{ route('miperfil.actualizar') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        </div>
    </div>
@endsection