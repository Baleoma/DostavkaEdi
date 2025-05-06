<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['content', 'rating', 'user_id', 'dish_id'];


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function dish() {
        return $this->belongsTo(Dish::class);
    }
}
