<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShoppingCartController;
use Illuminate\Support\Facades\Route;

// Public routes with rate limiting
Route::middleware('throttle:5,1')->group(function () {

    Route::post('/register', [AuthenticationController::class, 'register'])
        ->name('register');
    Route::post('/login', [AuthenticationController::class, 'login'])
        ->name('login');

});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthenticationController::class, 'logout'])
        ->name('logout');
    Route::apiResource('/products', ProductController::class)
        ->only(['index', 'show']);
    Route::apiResource('/cart', ShoppingCartController::class);
    Route::post('/cart/{productId}', [ShoppingCartController::class, 'removeProduct']);

    // Admin only routes
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('/products', ProductController::class)
            ->only(['store', 'update', 'destroy']);
    });
});
