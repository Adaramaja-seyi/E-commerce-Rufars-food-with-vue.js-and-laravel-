<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PaymentMethodController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Google OAuth routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// Products (public)
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/category/{category}', [ProductController::class, 'byCategory']);

// TEST ROUTE
Route::get('/test-address', function() {
    return response()->json(['message' => 'Test route works']);
});

// Email verification (public)
Route::post('/email/verify', [AuthController::class, 'verifyEmail']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user/profile', [AuthController::class, 'updateProfile']);
    Route::post('/email/resend', [AuthController::class, 'resendVerification']);
    
    // Addresses
    Route::get('/addresses', [AddressController::class, 'index']);
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::put('/addresses/{id}', [AddressController::class, 'update']);
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy']);
    Route::put('/addresses/{id}/default', [AddressController::class, 'setDefault']);
    
    // Payment Methods
    Route::get('/payment-methods', [PaymentMethodController::class, 'index']);
    Route::post('/payment-methods', [PaymentMethodController::class, 'store']);
    Route::put('/payment-methods/{id}', [PaymentMethodController::class, 'update']);
    Route::delete('/payment-methods/{id}', [PaymentMethodController::class, 'destroy']);
    Route::put('/payment-methods/{id}/default', [PaymentMethodController::class, 'setDefault']);
    
    // Cart
    Route::get('/cart', [CartController::class, 'getAllCart']);
    Route::post('/cart', [CartController::class, 'addItemCart']);
    Route::put('/cart/{id}', [CartController::class, 'update']);
    Route::delete('/cart/{id}', [CartController::class, 'remove']);
    Route::delete('/cart', [CartController::class, 'clear']);
    
    // Orders
    Route::get('/orders', [OrderController::class, 'getAllOrder']);
    Route::post('/orders', [OrderController::class, 'createOrder']);
    Route::get('/orders/{id}', [OrderController::class, 'getSingleOrder']);
    Route::put('/orders/{id}/cancel', [OrderController::class, 'cancelOrder']);
    
    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);
        Route::get('/admin/orders', [OrderController::class, 'adminIndex']);
        Route::put('/admin/orders/{id}/status', [OrderController::class, 'updateStatus']);
    });
});
