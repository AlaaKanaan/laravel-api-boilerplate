<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserTypes;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendOtp;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{


    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function store(Request $request): Response|JsonResponse
    {
        // Validate registration fields
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create the user
        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'authority' => [UserTypes::USER],
        ]);

        // Fire the Registered event (optional, for hooks)
        event(new Registered($user));


        if (config('app.enable_otp')) {
            $user->notify(new SendOtp());
            $data = ['otp_required' => true];
            throw new HttpResponseException($this->successResponse($data, __('auth.otp_sent')));
        } else {
            if ($request->is('api/*')) {
                $data = $user->getAuthTokens();
                return $this->successResponse($data, __('auth.registration_success'));
            } else {
                // Log the user in
                Auth::login($user);
                $request->session()->regenerate();
                return response()->noContent();
            }
        }
    }
}
