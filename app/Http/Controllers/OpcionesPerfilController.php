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
use App\Models\Valoracion;
use Illuminate\Support\Facades\Log;

class OpcionesPerfilController extends Controller
{
    public function compras()
    {
        $compras = CompraCoche::where('buyer_id', Auth::id())
            ->whereHas('car', function ($query) {
                $query->where('estado', 'Disponible');
            })
            ->with('car')
            ->get();
        return view('miperfil.compras', compact('compras'));
    }

    public function ventas()
    {
        $ventas = VentaCoche::where('seller_id', Auth::id())
            ->whereHas('car', function ($query) {
                $query->where('estado', 'Disponible');
            })
            ->with('car')
            ->get();
        return view('miperfil.ventas', compact('ventas'));
    }

    public function valoraciones()
    {
        $userId = Auth::id();
        $valoraciones = Valoracion::where('seller_id', $userId)
            ->whereHas('compra.car', function ($query) {
                $query->where('estado', 'Disponible');
            })
            ->with('buyer')
            ->get();
        return view('miperfil.valoraciones', compact('valoraciones'));
    }

    public function misAnuncios()
    {
        $cars = Car::where('user_id', Auth::id())
            ->where('estado', 'Disponible')
            ->get();
        $userId = Auth::id();

        $userIds = Message::where('receiver_id', $userId)
            ->orWhere('sender_id', $userId)
            ->pluck('sender_id', 'receiver_id')
            ->flatten()
            ->unique()
            ->filter(fn($id) => $id != $userId)
            ->toArray();

        $users = User::whereIn('id', $userIds)->get();

        return view('miperfil.misAnuncios', compact('cars', 'users'));
    }

    public function favoritos()
    {
        $favoritos = CocheFavorito::where('user_id', Auth::id())
            ->whereHas('car', function ($query) {
                $query->where('estado', 'Disponible');
            })
            ->with('car')
            ->get();
        return view('miperfil.favoritos', compact('favoritos'));
    }

    public function chats()
    {
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
            'password' => 'nullable|string|min:8|confirmed',
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

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->route('miperfil.editar')->with('success', 'Perfil actualizado correctamente.');
    }

    public function sell(Request $request)
    {
        Log::info('Sell request data:', $request->all());
    
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'buyer_id' => 'nullable|exists:users,id',
        ]);
    
        $car = Car::find($request->car_id);
        if ($car->user_id != Auth::id()) {
            return redirect()->route('miperfil.misAnuncios')->with('error', 'No tienes permiso para vender este coche.');
        }
    
        $seller_id = Auth::id();
        $buyer_id = $request->buyer_id;
    
        if (is_null($buyer_id)) {
            VentaCoche::create([
                'car_id' => $car->id,
                'seller_id' => $seller_id,
                'buyer_id' => 0,
            ]);
    
            $car->estado = 'Vendido';
            $car->save();
    
            return redirect()->route('miperfil.misAnuncios')->with('success', 'Coche vendido fuera de Wallacar.');
        }
    
        CompraCoche::create([
            'car_id' => $car->id,
            'buyer_id' => $buyer_id,
            'seller_id' => $seller_id,
        ]);
    
        VentaCoche::create([
            'car_id' => $car->id,
            'seller_id' => $seller_id,
            'buyer_id' => $buyer_id,
        ]);
    
        $car->estado = 'Vendido';
        $car->save();
    
        return redirect()->route('miperfil.misAnuncios')->with('success', 'Coche vendido exitosamente.');
    }

    public function createValoracion($compraId)
    {
        $compra = CompraCoche::with('car')->findOrFail($compraId);
    
        // Verificar si el usuario ya ha dejado una valoración para esta compra
        $existingValoracion = Valoracion::where('compra_id', $compraId)
            ->where('user_id', Auth::id())
            ->first();
    
        if ($existingValoracion) {
            return redirect()->route('miperfil.compras')->with('error', 'Ya has dejado una valoración para este coche.');
        }
    
        return view('valoraciones.create', compact('compra'));
    }

    public function storeValoracion(Request $request)
    {
        $request->validate([
            'compra_id' => 'required|exists:compras_coches,id',
            'rating' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string',
        ]);

        $compra = CompraCoche::findOrFail($request->compra_id);

        // Evitar valoraciones duplicadas
        $existingValoracion = Valoracion::where('compra_id', $request->compra_id)->where('user_id', Auth::id())->first();
        if ($existingValoracion) {
            return redirect()->route('miperfil.compras')->with('error', 'Ya has dejado una valoración para este coche.');
        }

        Valoracion::create([
            'compra_id' => $request->compra_id,
            'user_id' => Auth::id(),
            'seller_id' => $compra->seller_id,
            'rating' => $request->rating,
            'comentario' => $request->comentario,
        ]);

        $compra = CompraCoche::findOrFail($request->compra_id);
        $compra->valoracion_dejada = true;
        $compra->save();

        return redirect()->route('miperfil.compras')->with('success', 'Valoración guardada exitosamente.');
    }
}
