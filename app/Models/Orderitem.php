<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    protected $fillable = ['quantity', 'price', 'order_id', 'dish_id'];

    /** @use HasFactory<\Database\Factories\OrderitemFactory> */
    use HasFactory;

    public function dish() {
        return $this->belongsTo(Dish::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
