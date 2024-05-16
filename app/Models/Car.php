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
}
