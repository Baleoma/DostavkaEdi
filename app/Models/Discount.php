<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = ['min_order_amount', 'discount_percentage'];

    /** @use HasFactory<\Database\Factories\DiscountFactory> */
    use HasFactory;
}
