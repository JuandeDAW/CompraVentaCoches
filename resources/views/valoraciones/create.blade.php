@extends('miperfil.edit')

@section('content')
    <div class="container">
        <h1 class="my-4">Dejar una valoración para {{ $compra->car->marca }} {{ $compra->car->modelo }}</h1>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('valoraciones.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="compra_id" value="{{ $compra->id }}">
                    <div class="form-group row">
                        <label for="rating" class="col-sm-2 col-form-label">Puntuación</label>
                        <div class="col-sm-10">
                            <select name="rating" id="rating" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="comentario" class="col-sm-2 col-form-label">Comentario</label>
                        <div class="col-sm-10">
                            <textarea name="comentario" id="comentario" class="form-control" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Enviar valoración</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
