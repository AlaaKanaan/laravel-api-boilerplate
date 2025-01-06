<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\OtpVerificationRequest;
use App\Notifications\VerifyEmailOtp;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OTPController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified using an OTP.
     *
     * @param OtpVerificationRequest $request
     * @return JsonResponse
     */
    public function verify(OtpVerificationRequest $request): JsonResponse
    {
        // Validate the provided OTP
        $user = $request->validateOtp();
        // Check if the user's email is already verified
        if ($user->hasVerifiedEmail()) {
            return $this->successResponse(null, __('auth.email_already_verified'));
        }

        // Mark the email as verified
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $this->successResponse(null, __('auth.email_verified_successfully'));
    }

    public function resend(Request $request): JsonResponse
    {
        $user = $request->user();

        // Check if the user's email is already verified
        if ($user->hasVerifiedEmail()) {
            return $this->successResponse(null, __('auth.email_already_verified'));
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Verification OTP sent to your email address.',
        ], 200);
    }
}
