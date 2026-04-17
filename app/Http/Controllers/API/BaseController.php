<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function success($data, string $message = 'Berhasil', int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function successPaginated($resource, $message = 'Berhasil', int $code = 200)
    {
        return $resource->additional([
            'success' => true,
            'message' => $message,
        ], $code);
    }

    public function successCursorPaginated($data, $hasMore, $nextCursor = null, string $message = 'Berhasil', int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'has_more' => $hasMore,
            'next_cursor' => $nextCursor,
        ], $code);
    }

    public function error(string $message = 'Kesalahan', int $code = 400, $errors = null)
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

    public function created($data = null, string $message = 'Resource berhasil dibuat')
    {
        return $this->success($data, $message, 201);
    }

    public function updated($data = null, string $message = 'Resource berhasil diperbarui')
    {
        return $this->success($data, $message, 200);
    }

    public function deleted(string $message = 'Resource berhasil dihapus')
    {
        return $this->success(null, $message, 200);
    }

    public function notFound(string $message = 'Resource tidak ditemukan')
    {
        return $this->error($message, 404);
    }

    public function forbidden(string $message = 'Akses dilarang')
    {
        return $this->error($message, 403);
    }

    public function unauthorized(string $message = 'Tidak Diotorisasi')
    {
        return $this->error($message, 401);
    }

    public function tooManyAttempts(string $message = 'Terlalu banyak percobaan, silakan coba lagi nanti')
    {
        return $this->error($message, 429);
    }

    public function validationFailed($errors, string $message = 'Validasi gagal')
    {
        return $this->error($message, 422, $errors);
    }
}
