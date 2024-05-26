@extends('miperfil.edit')

@section('content')
<div class="container">
    <h1>Chat sobre {{ $car->marca }} {{ $car->modelo }}</h1>
    <div class="chat-box">
        @foreach($messages as $message)
            <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                <p>{{ $message->message }}</p>
                <small>{{ $message->created_at->format('H:i') }}</small>
            </div>
        @endforeach
    </div>
    <form action="{{ route('miperfil.chat.send', $car->id) }}" method="POST">
        @csrf
        <input type="hidden" name="receiver_id" value="{{ $messages->isEmpty() ? $car->user_id : ($messages->first()->sender_id == Auth::id() ? $messages->first()->receiver_id : $messages->first()->sender_id) }}">
        <div class="input-group">
            <input type="text" name="message" class="form-control" placeholder="Escribe un mensaje..." required>
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
        </div>
    </form>
</div>
@endsection

<style>
    .chat-box {
        max-height: 400px;
        overflow-y: scroll;
        margin-bottom: 20px;
    }
    .message {
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 10px;
        position: relative;
    }
    .message.sent {
        background-color: #d1f0d1;
        text-align: right;
        margin-left: auto;
    }
    .message.received {
        background-color: #f0f0f0;
    }
    .message p {
        margin: 0;
    }
    .message small {
        display: block;
        margin-top: 5px;
        font-size: 0.8em;
        color: #888;
    }
</style>
