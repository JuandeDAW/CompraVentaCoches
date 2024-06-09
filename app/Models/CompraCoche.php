<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraCoche extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'buyer_id',
        'car_id',
    ];

    protected $table = 'compras_coches';

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
}
