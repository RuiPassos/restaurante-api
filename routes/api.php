<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

// --- ROTAS PÚBLICAS (Acesso livre) ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);
Route::get('dishes', [DishController::class, 'index']);
Route::get('dishes/{dish}', [DishController::class, 'show']);

// --- ROTAS PROTEGIDAS (Exigem Token Sanctum) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // Perfil
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/me', [AuthController::class, 'updateMe']);

    // Reservas (Acesso para clientes autenticados)
    Route::get('reservations', [ReservationController::class, 'index']);
    Route::post('reservations', [ReservationController::class, 'store']);
    Route::get('reservations/{reservation}', [ReservationController::class, 'show']);
    Route::put('reservations/{reservation}', [ReservationController::class, 'update']);
    Route::patch('reservations/{reservation}/cancel', [ReservationController::class, 'cancel']);

    // --- ROTAS DE PROPRIETÁRIO (Admin) ---
    Route::middleware('is_admin')->group(function () {
        // Gerir Menu
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
        Route::post('dishes', [DishController::class, 'store']);
        Route::put('dishes/{dish}', [DishController::class, 'update']);
        Route::delete('dishes/{dish}', [DishController::class, 'destroy']);
        
        // Gerir Reservas
        Route::patch('reservations/{reservation}/status', [ReservationController::class, 'updateStatus']);
        Route::delete('reservations/{reservation}', [ReservationController::class, 'destroy']);
    });
});