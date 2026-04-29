<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function login(array $data)
    {
      $user = User::where ('email', $data['email'])->first();

      if (!$user || !Hash::check($data['password'], $user->password)) {
        return null;
      }

      $token = $user->createToken('auth_token')->plainTextToken;

      $this->activityLogService->log(
        $user->id,
        $user,
        'login',
        'users',
        'User berhasil  login ke sistem Go Sheep'
      );

      return [
        'user' => $user,
        'token' => $token,
      ];

    }
}
