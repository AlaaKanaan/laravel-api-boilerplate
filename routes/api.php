<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\Auth\AuthenticatedController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        require __DIR__ . '/auth.php';
        Route::middleware(['auth:sanctum', 'abilities:' . TokenAbility::REFRESH_TOKEN->value])->group(function () {
            Route::post('/refresh-token', [AuthenticatedController::class, 'refreshToken'])->name('refresh-token');
        });
    });
    Route::middleware(['auth:sanctum', 'abilities:' . TokenAbility::ACCESS_API->value])->group(function () {
        require __DIR__ . '/API/V1/main.php';
    });
});
