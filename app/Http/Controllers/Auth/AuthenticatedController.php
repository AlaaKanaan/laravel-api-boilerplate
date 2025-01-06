<?php

namespace App\Http\Controllers\Auth;

use App\Enums\TokenAbility;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedController extends Controller
{
    /**
     * Handle an incoming authentication request.
     * @throws ValidationException
     */
    public function store(LoginRequest $request): Response|JsonResponse
    {
        $request->authenticate();

        $user = request()->user();

        // Check if the user's email is verified
        if (!$user->hasVerifiedEmail()) {
            // Send email verification notification
            $user->sendEmailVerificationNotification();
            $data = $user->getVerifyToken();
            // Log out the user
            Auth::logout();
            // Return a success response
            return $this->createdResponse(
                $data ?? null,
                __('auth.email_not_verified')
            );
        }

        if ($request->is('api/*')) {
            $data = $request->user()->getAuthTokens();
            return $this->successResponse($data, __('auth.login_success'));
        } else {
            $request->session()->regenerate();
            return response()->noContent();
        }

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response|JsonResponse
    {
        if ($request->is('api/*')) {
            $request->user()->currentAccessToken()->delete();
            return $this->successResponse(null, __('auth.logout_success'));
        } else {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return response()->noContent();
        }
    }


    /**
     * Handle refresh token rotation.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function refreshToken(Request $request): JsonResponse
    {
        $user = $request->user();

        // Identify and delete the old refresh token
        $user->tokens()->where('name', TokenAbility::REFRESH_TOKEN->value)->delete();

        $data = $user->getAuthTokens();

        return $this->successResponse($data, __('auth.refresh_success'));
    }

}
