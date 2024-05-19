<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::all();
        return view('cars.index', compact('cars'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $cars = Car::where('marca', 'like', "%$query%")
                    ->orWhere('modelo', 'like', "%$query%")
                    ->get();
        return view('cars.index', compact('cars'));
    }

    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
{
    // Validar los datos del formulario
    $validatedData = $request->validate([
        'marca' => 'required|string|max:255',
        'modelo' => 'required|string|max:255',
        'color' => 'required|string|max:255',
        'imagenes.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'anio' => 'required|integer',
        'kilometraje' => 'required|integer',
        'distintivo_ambiental' => 'required|string|max:255',
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

    $car->save();

    // Manejar la subida de las imágenes
    if ($request->hasFile('imagenes')) {
        $userId = Auth::id();
        $userName = Auth::user()->username;
        $i = 0;
        foreach ($request->file('imagenes') as $image) {
            $path = $image->store('cars/' . $userId . '_' . $userName, 'public');
            // Guardar la ruta de la imagen en la base de datos
            if ($i == 0) {
                // Guardar la primera imagen como imagen principal
                $car->imagen = $path;
                $car->save();
            } else {
                $car->images()->create(['image_path' => $path]);
            }
            $i++;
        }
    }

    // Redireccionar a la lista de coches con un mensaje de éxito
    return redirect()->route('home')->with('success', 'Coche añadido correctamente');
}

}

