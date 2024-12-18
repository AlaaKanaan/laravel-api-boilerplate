<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::prefix('v1')->group(function () {
    require __DIR__ . '/auth.php';
    Route::middleware('auth:sanctum')->group(function () {
        require __DIR__ . '/API/V1/app.php';
    });
});

require __DIR__ . '/auth.php';
