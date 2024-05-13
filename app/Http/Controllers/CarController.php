<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car; // Asegúrate de importar el modelo Car

class CarController extends Controller
{
    // Mostrar la página de inicio
    public function index()
    {
        return view('home');
    }

    // Mostrar la lista de coches disponibles
    public function showCars()
    {
        $cars = Car::all(); // Obtener todos los coches de la base de datos
        return view('cars.index', ['cars' => $cars]); // Pasar los coches a la vista
    }

    // Mostrar el formulario de creación de un nuevo coche
    public function create()
    {
        return view('cars.create');
    }

    // Procesar la creación de un nuevo coche
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            // Agrega validaciones para otros campos aquí...
        ]);

        // Crear un nuevo objeto Car con los datos validados
        $car = new Car();
        $car->marca = $validatedData['marca'];
        $car->modelo = $validatedData['modelo'];
        // Continuar con otros campos...

        // Guardar el coche en la base de datos
        $car->save();

        // Redireccionar a la lista de coches con un mensaje de éxito
        return redirect()->route('cars.index')->with('success', 'Coche añadido correctamente');
    }
}

