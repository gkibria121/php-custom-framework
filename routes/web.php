<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use Framework\Route;


Route::get('/home', [HomeController::class, 'index']);
