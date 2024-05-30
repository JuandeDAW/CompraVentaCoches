<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    public function index()
    {
        $userId = Auth::id();
        $messages = Message::where('receiver_id', $userId)
                            ->orWhere('sender_id', $userId)
                            ->orderBy('created_at', 'desc')
                            ->get()
                            ->groupBy('car_id');

        return view('miperfil.chats', compact('messages'));
    }

    public function show($carId)
    {
        $userId = Auth::id();
        $car = Car::findOrFail($carId);
        $messages = Message::where(function ($query) use ($userId, $carId) {
                                $query->where('car_id', $carId)
                                      ->where('receiver_id', $userId);
                            })
                            ->orWhere(function ($query) use ($userId, $carId) {
                                $query->where('car_id', $carId)
                                      ->where('sender_id', $userId);
                            })
                            ->orderBy('created_at', 'asc')
                            ->get();

        return view('miperfil.chat', compact('messages', 'car'));
    }

    public function sendMessage(Request $request, $carId)
    {
        $request->validate([
            'message' => 'required|string|max:255',
            'receiver_id' => 'required|exists:users,id', 
        ]);
    
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'car_id' => $carId,
            'message' => $request->message,
            'read_at' => null,
        ]);
    
        return redirect()->route('miperfil.chat', $carId);
    }
    
}
