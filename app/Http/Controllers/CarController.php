<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car; // Asegúrate de importar el modelo Car
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    // Mostrar la página de bienvenida con todos los coches
    public function welcome()
    {
        $cars = Car::all(); // Obtener todos los coches de la base de datos
        return view('welcome', ['cars' => $cars]); // Pasar los coches a la vista
    }

    // Mostrar la lista de coches disponibles para usuarios autenticados
    public function index()
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
            'color' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'anio' => 'required|integer',
            'kilometraje' => 'required|integer',
            'distintivo_ambiental' => 'required|string',
            'combustible' => 'required|string|max:255',
            'cambio' => 'required|string|max:255',
            'motor' => 'required|string|max:255',
            'precio' => 'required|numeric',
        ]);

        // Crear un nuevo objeto Car con los datos validados
        $car = new Car();
        $car->marca = $validatedData['marca'];
        $car->modelo = $validatedData['modelo'];
        $car->color = $validatedData['color'];
        $car->anio = $validatedData['anio'];
        $car->kilometraje = $validatedData['kilometraje'];
        $car->distintivo_ambiental = $validatedData['distintivo_ambiental'];
        $car->combustible = $validatedData['combustible'];
        $car->cambio = $validatedData['cambio'];
        $car->motor = $validatedData['motor'];
        $car->precio = $validatedData['precio'];

        if ($request->hasFile('image')) {
            $userId = Auth::id();
            $path = $request->file('image')->store("images/{$userId}", 'public');
            $car->image = $path;
        }

        // Guardar el coche en la base de datos
        $car->save();

        // Redireccionar a la lista de coches con un mensaje de éxito
        return redirect()->route('cars.index')->with('success', 'Coche añadido correctamente');
    }
}
