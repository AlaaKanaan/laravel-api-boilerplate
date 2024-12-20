<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an API login request.
     */
    public function login(LoginRequest $request)
    {
        // Authenticate the user
        $request->authenticate();

        // Generate an API token (if using Sanctum)
        $token = $request->user()->createToken('api_token')->plainTextToken;

        // Return the response
        return response()->json([
            'message' => 'Login successful',
            'user' => $request->user(),
            'token' => $token,
        ]);
    }
}
