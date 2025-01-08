<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendOtp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PasswordResetLinkController extends Controller
{
    /**
     * Handle the request to store user information and send OTP notification.
     *
     * @param Request $request The incoming HTTP request containing the user email.
     *
     * @return JsonResponse The JSON response indicating the success of the operation.
     *
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);


        $user = User::query()->where('email', $request->input('email'))->first();
        $user->notify(new SendOtp());

        return $this->successResponse([], __('auth.otp_sent'));
    }
}
