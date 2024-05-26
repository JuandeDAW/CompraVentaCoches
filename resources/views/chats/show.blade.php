@extends('miperfil.edit')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Chat sobre: {{ $car->marca }} {{ $car->modelo }}</h4>
                </div>
                <div class="card-body">
                    <div id="messages-container" style="height: 400px; overflow-y: scroll;">
                        @foreach ($messages as $message)
                            <div class="message {{ $message->sender_id == Auth::id() ? 'text-right' : 'text-left' }}">
                                <p>{{ $message->message }}</p>
                                <small>{{ $message->created_at->diffForHumans() }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('chats.store', $car->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Escribe un mensaje..." required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .message.text-right {
        text-align: right;
    }
    .message.text-left {
        text-align: left;
    }
    #messages-container {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        background-color: #f9f9f9;
    }
</style>
@endsection