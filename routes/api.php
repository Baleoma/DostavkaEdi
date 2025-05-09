<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Подключение контроллеров
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RestaurantController;
use App\Http\Controllers\Api\DishController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\DiscountController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderitemController;
use App\Http\Controllers\Api\CartController;

// ======================
// ПУБЛИЧНЫЕ МАРШРУТЫ (Гости)
// ======================
Route::prefix('guest')->group(function () {
    // Авторизация
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Каталог
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/restaurants', [RestaurantController::class, 'index']);
    Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show']);
    Route::get('/dishes', [DishController::class, 'index']);
    Route::get('/dishes/{dish}', [DishController::class, 'show']);

    // Отзывы (только чтение)
    Route::get('/reviews', [ReviewController::class, 'index']);
    Route::get('/reviews/{review}', [ReviewController::class, 'show']);
    Route::get('/restaurants/{restaurantId}/reviews', [ReviewController::class, 'getrestaurantreviews']);
});

// ======================
// АВТОРИЗОВАННЫЕ ПОЛЬЗОВАТЕЛИ
// ======================
Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    // Профиль
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    // Корзина
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/{productId}', [CartController::class, 'addToCart']);
    Route::delete('/cart/{cartItemId}', [CartController::class, 'removeFromCart']);

    // Заказы
    Route::post('/orders', [OrderController::class, 'placeOrder']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);

    // Отзывы
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);

    // Аутентификация
    Route::get('/logout', [AuthController::class, 'logout']);
});

// ======================
// АДМИНИСТРАТОР
// ======================
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    // Справочники
    Route::apiResources([
        'categories' => CategoryController::class,
        'restaurants' => RestaurantController::class,
        'dishes' => DishController::class,
        'statuses' => StatusController::class,
        'discounts' => DiscountController::class,
        'orderitems' => OrderitemController::class,
    ]);

    // Управление пользователями
    Route::get('/users', [AuthController::class, 'index']);
    Route::delete('/users/{user}', [AuthController::class, 'destroy']);
});
