<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CocheFavorito;

class CocheFavoritoController extends Controller
{
    public function store(Request $request)
    {
        // Asegúrate de que los datos enviados estén validados correctamente

        $favorito = new CocheFavorito();
        $favorito->user_id = auth()->user()->id; // Obtén el ID del usuario autenticado
        $favorito->car_id = $request->car_id; // Asigna el ID del coche que se marcó como favorito
        $favorito->save();

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        // Encuentra y elimina el registro de favorito basado en el ID del usuario y el ID del coche
        CocheFavorito::where('user_id', auth()->user()->id)
                     ->where('car_id', $request->car_id)
                     ->delete();

        return response()->json(['success' => true]);
    }
}
