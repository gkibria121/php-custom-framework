<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Middlewares\FlashMessageMiddleware;
use App\Middlewares\SessionMiddleware;
use App\Middlewares\ValidationExceptionMiddleware;
use Framework\Route;



Route::group([SessionMiddleware::class, ValidationExceptionMiddleware::class, FlashMessageMiddleware::class], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/register', [AuthController::class, 'registerView']);
    Route::post('/register', [AuthController::class, 'register']);
});
