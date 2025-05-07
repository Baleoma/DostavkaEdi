<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = ['name', 'description', 'image', 'rating', 'opens_at', 'closes_at'];

    /** @use HasFactory<\Database\Factories\RestaurantFactory> */
    use HasFactory;


    public function reviews() {
        return $this->hasMany(Order::class, 'restaurant_id');
    }

    public function dishes() {
        return $this->hasMany(Dish::class, 'restaurant_id');
    }
}
