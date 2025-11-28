<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="API Documentation",
 *     version="1.0.0"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearer_token",
 *     type="http", 
 *     scheme="bearer",
 *     bearerFormat="token",
 *     in="header",
 *     name="Authorization"
 * )
 * @OA\Server(url="http://localhost:8000")
 */

class Controller extends BaseController 
{
    use AuthorizesRequests, ValidatesRequests;
    protected function jsonResponse($data = null, int $status = 200, array $headers = [], int $options = 0)
    {
        return response()->json($data, $status, $headers, $options);
    }
}