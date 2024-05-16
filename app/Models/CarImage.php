<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    use HasFactory;
    protected $fillable = ['image_path'];

    // Relación con el coche
    public function car()
    {
        return $this->belongsTo(Car::class);
    }


}
