<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends BaseController
{
    protected $authService;

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
}
