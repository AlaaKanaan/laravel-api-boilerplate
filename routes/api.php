<?php

use App\Enums\TokenAbility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        require __DIR__ . '/API/V1/auth.php';
    });
});

Route::middleware(['auth:sanctum', 'abilities:' . TokenAbility::ACCESS_API->value])->group(function () {
    JsonApiRoute::server('v1')
        ->prefix('v1')
        ->namespace('App\Http\Controllers\Api\V1')
        ->resources(function ($server) {

            $server->resource('users')
                ->parameter('id');
        });
});


