<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Food Delivery API",
 *     description="API for Food Delivery Application",
 *     @OA\Contact(
 *         email="admin@example.com"
 *     )
 * )
 */

Route::middleware('jwt.auth')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::middleware('jwt.auth')->group(function () {
        Route::post('/refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
        Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
        Route::get('/profile', [\App\Http\Controllers\AuthController::class, 'profile']);
        Route::put('/profile', [\App\Http\Controllers\AuthController::class, 'updateProfile']);
    });
});

// Restaurant Routes
Route::apiResource('restaurants', \App\Http\Controllers\RestaurantController::class);

// Menu Routes
Route::apiResource('menus', \App\Http\Controllers\MenuController::class);

// Order Routes
Route::apiResource('orders', \App\Http\Controllers\OrderController::class);

// Order Item Routes
Route::apiResource('order-items', \App\Http\Controllers\OrderItemController::class);

// Delivery Routes
Route::apiResource('deliveries', \App\Http\Controllers\DeliveryController::class);

// Review Routes
Route::apiResource('reviews', \App\Http\Controllers\ReviewController::class);
