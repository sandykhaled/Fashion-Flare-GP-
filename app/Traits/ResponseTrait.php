<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    /**
     * Success response.
     *
     * @param object|array $data
     * @param string $message
     *
     * @return JsonResponse
     */
    public static function responseSuccess(object|array $data, string $message = "Successful"): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'errors' => null
        ]);
    }

    /**
     * Error response.
     *
     * @param object|array $errors
     * @param string $message
     *
     * @return JsonResponse
     */
    public static function responseError(object|array $errors, string $message = "Something went wrong."): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => null,
            'errors' => $errors
        ]);
    }
}
