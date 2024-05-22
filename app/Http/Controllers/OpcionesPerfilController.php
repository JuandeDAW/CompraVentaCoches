<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Venta;
use App\Models\Car;
use App\Models\CocheFavorito;
use App\Models\CompraCoche;
use App\Models\Favourite;
use App\Models\VentaCoche;
use Illuminate\Support\Facades\Auth;

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
        return view('miperfil.misAnuncios', compact('cars'));
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

    public function actualizar(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('miperfil.editar')->with('success', 'Perfil actualizado correctamente.');
    }
}
