<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\PostController;


Route::get('/user-info', function (Request $request) {
    return $request->user();
});

Route::apiResource('posts', PostController::class); // Admin can manage all posts
