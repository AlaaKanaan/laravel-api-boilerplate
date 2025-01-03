<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});


require __DIR__ . '/Web/auth.php';
Route::middleware('auth')->group(function () {
    require __DIR__ . '/Web/main.php';
});
