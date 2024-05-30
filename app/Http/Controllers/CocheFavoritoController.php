<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CocheFavorito;

class CocheFavoritoController extends Controller
{
    public function store(Request $request)
    {
        

        $favorito = new CocheFavorito();
        $favorito->user_id = auth()->user()->id; 
        $favorito->car_id = $request->car_id; 
        $favorito->save();

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        CocheFavorito::where('user_id', auth()->user()->id)
                     ->where('car_id', $request->car_id)
                     ->delete();

        return response()->json(['success' => true]);
    }
}
