<?php


use App\Enums\TokenAbility;

use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Auth\AuthenticatedController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\OTPController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Traits\ApiResponse;

Route::post('/sign-up', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/sign-in', [AuthenticatedController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::post('/verify-otp', [OTPController::class, 'verify'])
    ->middleware([request()->is('api/*') ? 'auth:sanctum' : 'auth', 'throttle:6,1', 'abilities:' . TokenAbility::VERIFY_TOKEN->value])
    ->name('verification.verify');

Route::post('/resend-otp', [OTPController::class, 'resend'])
    ->middleware([request()->is('api/*') ? 'auth:sanctum' : 'auth', 'throttle:6,1', 'abilities:' . TokenAbility::VERIFY_TOKEN->value])
    ->name('verification.verify');

Route::post('/sign-out', [AuthenticatedController::class, 'destroy'])
    ->middleware(request()->is('api/*') ? 'auth:sanctum' : 'auth')
    ->name('logout');
