<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    /**
     * Handles the password reset process for a user.
     *
     * Validates the provided request data including OTP, email, and password.
     * It checks the cached OTP, updates the user's password if validation succeeds,
     * and removes the OTP identifier value after completion.
     *
     * @param Request $request The incoming HTTP request object containing validation inputs.
     *
     * @return JsonResponse A successful JSON response indicating password change.
     * @throws ValidationException If the provided OTP is invalid or expired.
     *
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'otp' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::query()->where('email', $request->input('email'))->first();
        // Retrieve OTP from the cache
        $cachedOtp = $user->getOTPIdentifierValue();

        // Validate the OTP
        if (!$cachedOtp || $cachedOtp !== $request->input('otp')) {
            throw ValidationException::withMessages([
                'otp' => __('auth.invalid_or_expired_otp'),
            ]);
        }

        $user->forceFill([
            'password' => Hash::make($request->string('password')),
            'remember_token' => Str::random(60),
        ])->save();

        $user->deleteOTPIdentifierValue();

       return $this->successResponse([], __('auth.password_changed'));
    }
}
