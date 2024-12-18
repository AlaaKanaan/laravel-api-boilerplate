<?php

use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::post('/login', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json(['token' => $token]);
    });
    Route::middleware('auth:sanctum')->group(function () {
        require __DIR__ . '/API/V1/app.php';
    });
});
