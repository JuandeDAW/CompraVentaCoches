<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\CompraCoche;
use App\Models\VentaCoche;
use App\Models\Car;
use App\Models\CocheFavorito;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Chat;
use App\Models\Message;

class OpcionesPerfilController extends Controller
{
    public function compras()
    {
        $compras = CompraCoche::where('buyer_id', Auth::id())->with('car', 'seller')->get();
        return view('miperfil.compras', compact('compras'));
    }

    public function ventas()
    {
        $ventas = VentaCoche::where('seller_id', Auth::id())->with('car', 'buyer')->get();
        return view('miperfil.ventas', compact('ventas'));
    }

    public function valoraciones()
    {
        // Suponiendo que hay un modelo Valoracion
        $valoraciones = Auth::user()->valoraciones;
        return view('miperfil.valoraciones', compact('valoraciones'));
    }

    public function misAnuncios()
    {
        $cars = Car::where('user_id', Auth::id())->get();
        $userId = Auth::id();

        // Obtener los usuarios con los que ha chateado excluyendo al usuario autenticado
        $userIds = Message::where('receiver_id', $userId)
            ->orWhere('sender_id', $userId)
            ->pluck('sender_id', 'receiver_id')
            ->flatten()
            ->unique()
            ->filter(fn ($id) => $id != $userId)
            ->toArray();

        $users = User::whereIn('id', $userIds)->get();

        return view('miperfil.misAnuncios', compact('cars', 'users'));
    }

    public function favoritos()
    {
        $favoritos = CocheFavorito::where('user_id', Auth::id())->with('car')->get();
        return view('miperfil.favoritos', compact('favoritos'));
    }

    public function chats()
    {
        // Suponiendo que hay un modelo Chat
        $chats = Auth::user()->chats;
        return view('miperfil.chats', compact('chats'));
    }

    public function editar()
    {
        return view('miperfil.editar');
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'username' => 'required|string|max:255|unique:users,username,' . $id,
        ]);

        $user = Auth::user();

        if ($user->id != $id) {
            return redirect()->route('miperfil.editar', $user->id)->with('error', 'No tienes permiso para actualizar este perfil.');
        }

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->save();

        return redirect()->route('miperfil.editar')->with('success', 'Perfil actualizado correctamente.');
    }

    public function sell(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'buyer_id' => 'required|exists:users,id',
        ]);

        $car = Car::find($request->car_id);
        if ($car->user_id != Auth::id()) {
            return redirect()->route('miperfil.misAnuncios')->with('error', 'No tienes permiso para vender este coche.');
        }

        VentaCoche::create([
            'car_id' => $car->id,
            'seller_id' => Auth::id(),
            'buyer_id' => $request->buyer_id,
        ]);

        $car->update(['user_id' => $request->buyer_id]);

        return redirect()->route('miperfil.misAnuncios')->with('success', 'Coche vendido correctamente.');
    }
}
