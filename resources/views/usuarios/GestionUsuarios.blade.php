@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestión de Usuarios</h1>

    <div class="mb-3">
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">Crear Usuario</a>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <form action="{{ route('usuarios.index') }}" method="GET" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Buscar usuarios" value="{{ request()->query('search') }}">
    </form>

    <table class="table">
        <thead>
            <tr>
                 <th>Id</th>
                 <th>Nombre</th>
                 <th>Email</th>
                 <th>Nombre de Usuario</th>
                 <th>Fecha Alta</th>
                 <th>Perfil</th>
                 <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                <td> {{ $usuario->id }}<br></td>
                        <td>{{$usuario->name}}</td>
                        <td>{{$usuario->email}}</td>
                        <td>{{$usuario->username}}</td>
                        <td>{{$usuario->created_at}}</td>
                        <td>{{$usuario->profile}}</td>
                    <td>
                       
                        @if ($usuario->activo)
                            <form action="{{ route('usuarios.desactivar', $usuario->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning">Desactivar</button>
                            </form>
                        @else
                            <form action="{{ route('usuarios.activar', $usuario->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">Activar</button>
                            </form>
                        @endif
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-primary">Editar</a> 

                       

                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</button>
                        </form>
                        <a href="{{ route('cars.user', $usuario->id) }}" class="btn btn-info">Ver Anuncios</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $usuarios->links() }}
</div>
@endsection