@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content mt-5">
        <h1>Eliminar Coche</h1>
        <p>¿Estás seguro de que quieres eliminar este coche?</p>
        <form action="{{ route('cars.destroy', $car->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Sí, eliminar</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
