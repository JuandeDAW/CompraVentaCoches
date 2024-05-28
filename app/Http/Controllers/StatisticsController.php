<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\Car;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->profile == 'admin') {
                return $next($request);
            } else {
                abort(403); 
            }
        });
    }
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
