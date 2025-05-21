<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\CorsMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware([CorsMiddleware::class]) // Applique le middleware CORS
    ->prefix('/v1')
    ->group(function () {
        Route::prefix('/users')->group(function () {
            Route::post('/register', [UserController::class, 'store'])->name('user.register');
            Route::post('/login', [UserController::class, 'login'])->name('user.login');
            Route::middleware('auth:sanctum')->group(function () {
                Route::get('/profile/{id}', [UserController::class, 'show'])->name('user.profiles');
                Route::post('/profile/{id}', [UserController::class, 'update'])->name('user.update');
            });
        });
});
