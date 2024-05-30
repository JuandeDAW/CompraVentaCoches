<?php

namespace App\Http\Controllers;

use App\Models\CompraCoche;
use Illuminate\Http\Request;

class ComprasCocheController extends Controller
{
    public function store(Request $request)
    {
        
        $compraCoche = new CompraCoche();
        $compraCoche->buyer_id = auth()->user()->id; 
        $compraCoche->seller_id = $request->seller_id; 
        $compraCoche->car_id = $request->car_id; 
        $compraCoche->save(); 

        
        return response()->json(['success' => true]);
    }
}
