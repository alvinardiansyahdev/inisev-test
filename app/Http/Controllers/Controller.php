<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    protected function responseSuccess(string $message): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    protected function responseError(string $message, int $code = 500): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $code);
    }
}
