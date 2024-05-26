<?php

namespace App\Http\Controllers;

use App\Models\CompraCoche;
use Illuminate\Http\Request;

class ComprasCocheController extends Controller
{
    public function store(Request $request)
    {
        // Asegúrate de que los datos enviados estén validados correctamente
        
        // Crea una nueva instancia del modelo CompraCoche
        $compraCoche = new CompraCoche();
        $compraCoche->buyer_id = auth()->user()->id; // Obtén el ID del comprador autenticado
        $compraCoche->seller_id = $request->seller_id; // Asigna el ID del vendedor del coche
        $compraCoche->car_id = $request->car_id; // Asigna el ID del coche comprado
        $compraCoche->save(); // Guarda la compra en la base de datos

        // Redirige a alguna página o devuelve una respuesta JSON, según tus necesidades
        return response()->json(['success' => true]);
    }
}
