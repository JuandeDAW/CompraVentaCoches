<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CocheFavoritoController;
use App\Http\Controllers\ComprasCocheController;
use App\Http\Controllers\OpcionesPerfilController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\StatisticsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cars', function () {
    return view('cars.index');
})->middleware(['auth', 'verified'])->name('cars.index');

Route::get('/', [CarController::class, 'index'])->name('home');
Route::get('/cars/search', [CarController::class, 'search'])->name('cars.search');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');
Route::get('/sort', [CarController::class, 'sort'])->name('cars.sort');


 //Usuarios autentificados y activos
Route::middleware(['auth', 'activo'])->group(function () {
    Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
    Route::get('/create', [CarController::class, 'create'])->name('create');
    Route::post('/cars', [CarController::class, 'store'])->name('store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
    Route::put('/cars/{car}', [CarController::class, 'update'])->name('cars.update');
    Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
  

    //Ruta gestion usuarios (admin)

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::resource('usuarios', UsuarioController::class);
        Route::get('/user/{id}', [CarController::class, 'UserCar'])->name('cars.user');
        Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
        Route::put('/usuarios/{id}/activar', [UsuarioController::class, 'activar'])->name('usuarios.activar');
        Route::put('/usuarios/{id}/desactivar', [UsuarioController::class, 'desactivar'])->name('usuarios.desactivar');
           
        });
       
    
 
        //Opciones perfil
        Route::get('/miperfil/compras', [OpcionesPerfilController::class, 'compras'])->name('miperfil.compras');
        Route::get('/miperfil/ventas', [OpcionesPerfilController::class, 'ventas'])->name('miperfil.ventas');
        Route::get('/miperfil/valoraciones', [OpcionesPerfilController::class, 'valoraciones'])->name('miperfil.valoraciones');
        Route::get('/miperfil/misAnuncios', [OpcionesPerfilController::class, 'misAnuncios'])->name('miperfil.misAnuncios');
        Route::get('/miperfil/favoritos', [OpcionesPerfilController::class, 'favoritos'])->name('miperfil.favoritos');
        Route::get('/miperfil/chats', [OpcionesPerfilController::class, 'chats'])->name('miperfil.chats');
        Route::get('/miperfil/editar', [OpcionesPerfilController::class, 'editar'])->name('miperfil.editar');
        Route::patch('/miperfil/editar/{id}', [OpcionesPerfilController::class, 'actualizar'])->name('miperfil.actualizar');

        //Guardar coches como favoritos
        Route::post('/coches-favoritos/store', [CocheFavoritoController::class, 'store'])->name('coches.favoritos.store');
        Route::delete('/coches-favoritos/{car_id}', [CocheFavoritoController::class, 'destroy'])->name('coches.favoritos.destroy');

        //Chats entre usuarios
        Route::get('/miperfil/chats', [ChatController::class, 'index'])->name('miperfil.chats');
        Route::get('/miperfil/chats/{carId}', [ChatController::class, 'show'])->name('miperfil.chat');
        Route::post('/miperfil/chats/{carId}', [ChatController::class, 'sendMessage'])->name('miperfil.chat.send');

});

require __DIR__.'/auth.php';
