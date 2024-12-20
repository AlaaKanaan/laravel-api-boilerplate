<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        require __DIR__ . '/API/V1/auth.php';
    });
    Route::middleware('auth:sanctum')->group(function () {
        require __DIR__ . '/App/V1/main.php';
    });
});
