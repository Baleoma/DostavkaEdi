<?php

use App\Http\Controllers\Api\CategoryController;
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
    ]);

    // Выход из системы
    Route::get('/logout', [AuthController::class, 'logout']);
});
