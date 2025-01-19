<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{

    public function responseServer(int $statusCode, array $data) : JsonResponse
    {
        return response()->json($data, $statusCode, [], JSON_PRETTY_PRINT);
    }
}
