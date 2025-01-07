<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Notifications\SendOtp;
use App\Traits\ApiResponse;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    use ApiResponse;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }


    /**
     * @throws ValidationException
     */
    public function validateAuthentication()
    {
        $this->ensureIsNotRateLimited();

        if (!Auth::validate($this->only('email', 'password'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $user = User::query()->where('email', $this->input('email'))->first();

        if (config('app.enable_otp')) {
            if (empty($this->input('otp'))) {
                $user->notify(new SendOtp());
                $data = ['otp_required' => true];
                throw new HttpResponseException($this->successResponse($data, __('auth.otp_sent')));
            } else {
                $this->validate([
                    'otp' => ['required']
                ]);

                $otp = $this->input('otp');

                // Retrieve OTP from the cache
                $cachedOtp = $user->getOTPIdentifierValue();

                // Validate the OTP
                if (!$cachedOtp || $cachedOtp !== $otp) {
                    throw ValidationException::withMessages([
                        'otp' => __('auth.invalid_or_expired_otp'),
                    ]);
                }
                $user->deleteOTPIdentifierValue();
            }
        }

        RateLimiter::clear($this->throttleKey());

        return $user;
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
    }
}
