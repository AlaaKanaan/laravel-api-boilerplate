<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\PostController;


Route::get('/user', function (Request $request) {
    return $request->user();
});
