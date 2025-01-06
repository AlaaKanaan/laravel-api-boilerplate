<?php

namespace App\Http\Requests\Auth;

use App\Enums\CacheKeys;
use App\Enums\TokenAbility;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class OtpVerificationRequest
{
    /**
     * Validate the provided OTP for email verification.
     *
     * @return mixed
     */
    public function validateOtp(): mixed
    {
        $user = request()->user();

        $otp = request()->input('otp');

        // Retrieve OTP from the cache
        $cachedOtp = Cache::get(CacheKeys::OTP_KEY->value . $user['id']);

        // Validate the OTP
        if (!$cachedOtp || $cachedOtp !== $otp) {
            abort(422, __('auth.invalid_or_expired_otp', [
                'attribute' => 'OTP'
            ]));
        }

        Cache::delete(CacheKeys::OTP_KEY->value . $user['id']);
        $user->tokens()->where('name', TokenAbility::VERIFY_TOKEN->value)->delete();

        return $user;
    }
}
