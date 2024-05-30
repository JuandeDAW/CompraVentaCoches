<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\CocheFavorito;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{

    public function index()
    {
     
        $cars = Car::simplePaginate(9);
        
        return view('cars.index', compact('cars'));
    }

    public function UserCar($id)
    {

             $us = User::find($id);
            $cars = $us->cars;
            return view('GestionCochesUsuarios.index', compact('us', 'cars'));
            
    }


    public function sort(Request $request)
{
    $sortOption = $request->input('sort');
    
    switch ($sortOption) {
        case 'price_asc':
            $cars = Car::orderBy('precio', 'asc')->paginate(9);
            break;
        case 'price_desc':
            $cars = Car::orderBy('precio', 'desc')->paginate(9);
            break;
        case 'date_asc':
            $cars = Car::orderBy('created_at', 'asc')->paginate(9);
            break;
        case 'date_desc':
            $cars = Car::orderBy('created_at', 'desc')->paginate(9);
            break;
        default:
        $cars = Car::paginate(9);
    }

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

 



    public function show($id)
    {
        $car = Car::find($id);
        $isFavorite = false;
    
        if (auth()->check()) {
            $isFavorite = CocheFavorito::where('user_id', auth()->user()->id)
                                       ->where('car_id', $id)
                                       ->exists();
        }
    
        return view('cars.show', compact('car', 'isFavorite'));
    }
    

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
{
    Log::info('Inicio de la solicitud de almacenamiento de coche.');

    // Validar los datos del formulario
    $validatedData = $request->validate([
        'marca' => 'required|string|max:255',
        'modelo' => 'required|string|max:255',
        'color' => 'required|string|max:255',
        'imagen_principal' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'imagenes_adicionales.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'anio' => 'required|integer',
        'kilometraje' => 'required|integer',
        'distintivo_ambiental' => 'required|string|max:255',
        'combustible' => 'required|string|max:255',
        'cambio' => 'required|string|max:255',
        'motor' => 'required|string|max:255',
        'precio' => 'required|numeric',
        'descripcion' => 'nullable|string|max:1000'
    ]);

    Log::info('Datos validados:', $validatedData);

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
    $car->descripcion = $validatedData['descripcion'];
    $car->user_id = auth()->user()->id;

    // Guardar la imagen principal del coche en la tabla "cars"
    if ($request->hasFile('imagen_principal') && $request->file('imagen_principal')->isValid()) {
        $userId = auth()->user()->id;
        $userName = auth()->user()->username;
        $imagePath = $request->file('imagen_principal')->store('cars/' . $userId . '_' . $userName, 'public');
        $car->imagen = $imagePath;
        Log::info('Imagen principal del coche guardada en la tabla Cars.');
    }

    // Guardar el coche en la base de datos
    $car->save();
    Log::info('Coche guardado:', ['car_id' => $car->id]);

    // Manejar la subida de imágenes adicionales
    if ($request->hasFile('imagenes_adicionales')) {
        Log::info('Inicio de la subida de imágenes adicionales.');
        foreach ($request->file('imagenes_adicionales') as $image) {
            if ($image->isValid()) {
                $userId = auth()->user()->id;
                $userName = auth()->user()->username;
                $imagePath = $image->store('cars/' . $userId . '_' . $userName, 'public');
                // Guardar la ruta de la imagen en la tabla "car_images"
                $car->images()->create(['image_path' => $imagePath]);
                Log::info('Imagen adicional del coche guardada en la tabla CarImages.');
            }
        }
        Log::info('Proceso de subida de imágenes adicionales completado.');
    }

    // Redireccionar con mensaje de éxito
    return redirect()->route('home')->with('success', 'Coche añadido correctamente');
}





    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $validatedData = $request->validate([
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'anio' => 'required|integer',
            'kilometraje' => 'required|integer',
            'distintivo_ambiental' => 'required|string|max:255',
            'combustible' => 'required|string|max:255',
            'cambio' => 'required|string|max:255',
            'motor' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'descripcion' => 'nullable|string|max:1000',
            'imagenes.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $userId = Auth::id();
        $userName = Auth::user()->username;
        $userFolder = 'cars/' . $userId . '_' . $userName;

        if ($request->hasFile('imagen')) {
            if ($car->imagen) {
                Storage::disk('public')->delete($car->imagen);
            }
            $imagePath = $request->file('imagen')->store($userFolder, 'public');
            $validatedData['imagen'] = $imagePath;
        }

        $car->update($validatedData);

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $image) {
                $path = $image->store($userFolder, 'public');
                $car->images()->create(['image_path' => $path]);
            }
        }

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
