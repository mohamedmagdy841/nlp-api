<?php

namespace App\Http\Helpers;

class ApiResponse
{
    public static function sendResponse($data = [], $message = [], $code = 200)
    {
        $response = [
            'state' => $code,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($response, $code);
    }
}
