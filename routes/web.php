<?php

declare(strict_types=1);

use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Middlewares\TemplateMiddleware;
use Framework\Route;



Route::get('/dashboard', [DashboardController::class, 'index'])->middlewares([TemplateMiddleware::class, TemplateMiddleware::class]);
