<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    public function success(string $message, ?array $data = null, int $code = 200): JsonResponse
    {

        return response()
            ->json([
                'success' => true,
                'message' => $message,
                'data' => $data,
            ], $code);
    }

    public function failed(string $message, int $code = 400): JsonResponse
    {

        return response()
            ->json([
                'success' => false,
                'message' => $message,
            ], $code);
    }
}
