<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DiscountController;
use App\Http\Controllers\Api\DishController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderitemController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

// Публичные маршруты (без авторизации)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Защищенные маршруты (с авторизацией)
Route::middleware('auth:sanctum')->group(function () {
    // Информация о текущем пользователе
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

// Ресурсы API
    Route::apiResources([
        'categories' => CategoryController::class,
        'statuses' => StatusController::class,
        'discounts' => DiscountController::class,
        'restaurants' => RestaurantController::class,
        'dishes' => DishController::class,
        'orders' => OrderController::class,
        'orderitems' => OrderitemController::class,
        'carts' => CartController::class,
        'reviews' => ReviewController::class,
    ]);

    // Выход из системы
    Route::get('/logout', [AuthController::class, 'logout']);
});
