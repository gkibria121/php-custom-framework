<?php

declare(strict_types=1);

use App\Controllers\{AuthController,   HomeController, ReceiptController, TransactionController};
use App\Middlewares\{
    AuthOnlyMiddleware,
    CSRFGuardMiddleware,
    CSRFTokenMiddleware,
    FlashMessageMiddleware,
    GuestOnlyMiddleware,
    SessionMiddleware,
    ValidationExceptionMiddleware
};
use Framework\Route;



Route::group([
    SessionMiddleware::class,
    ValidationExceptionMiddleware::class,
    FlashMessageMiddleware::class,
    CSRFTokenMiddleware::class,
    CSRFGuardMiddleware::class,


], function () {
    Route::get('/about', [HomeController::class, 'about']);

    Route::group([AuthOnlyMiddleware::class], function () {
        Route::get('/', [TransactionController::class, 'index']);

        Route::get('/logout', [AuthController::class, 'logout']);
        Route::get('/transactions/create', [TransactionController::class, 'createView']);
        Route::post('/transactions/create', [TransactionController::class, 'create']);
        Route::get('/transactions/{id}/edit', [TransactionController::class, 'editView']);
        Route::put('/transactions/{id}/edit', [TransactionController::class, 'edit']);
        Route::delete('/transactions/{id}/delete', [TransactionController::class, 'delete']);
        Route::get('/transactions/{transaction_id}/receipt/upload', [ReceiptController::class, 'createView']);
        Route::post('/transactions/{transaction_id}/receipt/upload', [ReceiptController::class, 'create']);
    });
    Route::group([GuestOnlyMiddleware::class], function () {
        Route::get('/register', [AuthController::class, 'registerView']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::get('/login', [AuthController::class, 'loginView']);
        Route::post('/login', [AuthController::class, 'login']);
    });
});
