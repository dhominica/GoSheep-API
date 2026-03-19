<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function success($data, string $message = 'Success', int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function error(string $message = 'Error', int $code = 400, $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    public function created($data = null, string $message = 'Resource created successfully')
    {
        return $this->success($data, $message, 201);
    }

    public function updated($data = null, string $message = 'Resource updated successfully')
    {
        return $this->success($data, $message, 200);
    }

    public function deleted(string $message = 'Resource deleted successfully')
    {
        return $this->success(null, $message, 200);
    }

    public function notFound(string $message = 'Resource not found')
    {
        return $this->error($message, 404);
    }

    public function forbidden(string $message = 'Forbidden')
    {
        return $this->error($message, 403);
    }

    public function unauthorized(string $message = 'Unauthorized')
    {
        return $this->error($message, 401);
    }

    public function tooManyAttempts(string $message = 'Too many attempts, please try again later')
    {
        return $this->error($message, 429);
    }

    public function validationFailed($errors, string $message = 'Validation failed')
    {
        return $this->error($message, 422, $errors);
    }
}
