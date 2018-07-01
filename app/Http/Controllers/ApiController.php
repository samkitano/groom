<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    protected function respondOk($payload = 'OK'): JsonResponse
    {
        return response()->json($payload);
    }

    protected function respondNotFound($item = 'File'): JsonResponse
    {
        return response()->json("{$item} Not Found", 404);
    }

    protected function respondUnprocessable($msg = 'Unprocessable Entity') :JsonResponse
    {
        return response()->json($msg, 422);
    }
}
