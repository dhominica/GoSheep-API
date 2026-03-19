<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function login(array $data)
    {
        if (Auth::attempt($data)) {

            $user = Auth::user();

            if (is_null($user->email_verified_at)) {
              Auth::logout();

              return null;
            }

            $token = $user->createToken('api-token')->plainTextToken;

            $this->activityLogService->log(
              $user->id,
              null,
              'login_success',
              null,
              ['token' => $token],
              'User berhasil login',
            );

            return [
              'user' => $user,
              'token' => $token,
            ];
        }

        return null;
    }
}
