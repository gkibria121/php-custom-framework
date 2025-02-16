<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Middlewares\CSRFGuardMiddleware;
use App\Middlewares\CSRFTokenMiddleware;
use App\Middlewares\FlashMessageMiddleware;
use App\Middlewares\SessionMiddleware;
use App\Middlewares\ValidationExceptionMiddleware;
use Framework\Route;



Route::group([
    SessionMiddleware::class,
    ValidationExceptionMiddleware::class,
    FlashMessageMiddleware::class,
    CSRFTokenMiddleware::class,
    CSRFGuardMiddleware::class,

], function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/about', [HomeController::class, 'about']);
    Route::get('/register', [AuthController::class, 'registerView']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'loginView']);
    Route::post('/login', [AuthController::class, 'login']);
});
