<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['total_price', 'discount', 'final_price', 'address', 'comment', 'status_id', 'user_id', 'restaurant_id'];

    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    public function restaurant() {
        return $this->belongsTo(Restaurant::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function orderitems() {
        return $this->hasMany(Orderitem::class, 'order_id');
    }
}
