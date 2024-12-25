<?php

use App\Enums\TokenAbility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        require __DIR__ . '/API/V1/auth.php';
    });
    Route::middleware(['auth:sanctum', 'abilities:' . TokenAbility::ACCESS_API->value])->group(function () {
        require __DIR__ . '/API/V1/main.php';
    });
});
