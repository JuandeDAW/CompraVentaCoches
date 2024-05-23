<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::all();
        return view('cars.index', compact('cars'));
    }

    public function UserCar($id)
    {
        $us = User::find($id);
        $cars = $us->cars;
        return view('GestionCochesUsuarios.index', compact('us', 'cars'));
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
        $car->user_id = auth()->user()->id;

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

    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
{
    $validatedData = $request->validate([
        'marca' => 'required|string',
        'modelo' => 'required|string',
        'color' => 'required|string',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'anio' => 'required|integer',
        'kilometraje' => 'required|integer',
        'distintivo_ambiental' => 'required|string',
        'combustible' => 'required|string',
        'cambio' => 'required|string',
        'motor' => 'required|string',
        'precio' => 'required|numeric',
        'imagenes.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Permitir múltiples imágenes
    ]);

    $userId = Auth::id();
    $userName = Auth::user()->username;
    $userFolder = 'cars/' . $userId . '_' . $userName;

    // Manejar la imagen principal
    if ($request->hasFile('imagen')) {
        // Si el coche ya tiene una imagen, la borramos primero
        if ($car->imagen) {
            Storage::disk('public')->delete($car->imagen);
        }
        $imagePath = $request->file('imagen')->store($userFolder, 'public');
        $validatedData['imagen'] = $imagePath; // Actualiza la ruta de la imagen principal en los datos validados
    }

    $car->update($validatedData); // Actualiza el modelo con los datos validados

// Manejar la subida de las imágenes adicionales
if ($request->hasFile('imagenes')) {
    foreach ($request->file('imagenes') as $image) {
        $path = $image->store($userFolder, 'public');
        $car->images()->create(['image_path' => $path]);
    }
}




    // Manejar la eliminación de imágenes
    if ($request->filled('remove_images')) {
        foreach ($request->input('remove_images') as $imageId) {
            $image = $car->images()->find($imageId);
            if ($image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }
    }

    return redirect()->route('cars.index')->with('success', 'Coche actualizado correctamente');
}

    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index')->with('success', 'Coche eliminado exitosamente');
    }
}
