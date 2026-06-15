<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $email = $request->input('email');
        $ip = $request->ip();
        $key = 'login.' . $email . '.' . $ip;

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return $this->tooManyAttempts(
                'Terlalu banyak percobaan login. Coba lagi nanti.',
            );
        }

        $result = $this->authService->login($request->validated());

        if (!$result) {
            RateLimiter::hit($key, 60 * 5);
            return $this->error('Email atau password salah', 401);
        }

        RateLimiter::clear($key);

        return $this->success([
            'token' => $result['token'],
            'user' => new UserResource($result['user']),
        ], 'Login berhasil');
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return $this->success(null, 'Logout Berhasil'); 
    }

    public function requestPasswordReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = \App\Models\User::where('email', $request->email)->where('role', 'peternak')->first();

        if ($user) {
            $user->update(['request_password_reset' => true]);
        }

        // Always return success to prevent email enumeration
        return $this->success(null, 'Jika email terdaftar sebagai peternak, permintaan reset kata sandi telah dikirim ke admin.');
    }
}
