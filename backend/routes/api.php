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
        });
});
