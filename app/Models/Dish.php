<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $fillable = ['name', 'description', 'price', 'image', 'is_available', 'restaurant_id', 'category_id'];

    /** @use HasFactory<\Database\Factories\DishFactory> */
    use HasFactory;

    public function restaurant() {
        return $this->belongsTo(Restaurant::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function orderitems() {
        return $this->hasMany(Orderitem::class, 'dish_id');
    }
}
