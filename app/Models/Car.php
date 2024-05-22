<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable = [
        'marca', 
        'modelo', 
        'color', 
        'imagen', 
        'anio', 
        'kilometraje', 
        'distintivo_ambiental', 
        'combustible', 
        'cambio', 
        'motor', 
        'precio'
    ];

    public function images()
    {
        return $this->hasMany(CarImage::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con compras
    public function compras()
    {
        return $this->hasMany(CompraCoche::class);
    }

    // Relación con ventas
    public function ventas()
    {
        return $this->hasMany(VentaCoche::class);
    }

    // Relación con favoritos
    public function favourites()
    {
        return $this->hasMany(CocheFavorito::class);
    }
}
