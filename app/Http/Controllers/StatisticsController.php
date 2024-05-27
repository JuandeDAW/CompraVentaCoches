<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Car;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCars = Car::count();
       
        $usersByDay = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
         ->groupBy('date')
         ->orderBy('date')
         ->get();

        $carsByDay = Car::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date')
         ->get();

        return view('Statistics.index', [
            'totalUsers' => $totalUsers,
            'totalCars' => $totalCars,
            'usersByDay' => $usersByDay,
            'carsByDay' => $carsByDay,
          
        ]);


    }
}
