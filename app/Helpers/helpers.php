<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Access\Response as AuthResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;

if (!function_exists('Authorize')) {
    /**
     * Authorize a given action for the current user.
     * @param  mixed  $ability
     * @param  mixed|array  $arguments
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    function Authorize($ability, $arguments = []): AuthResponse
    {
        static $class = null;

        if ($class === null) {
            $class = new class()
            {
                use AuthorizesRequests;
            };
        }

        return $class->authorize($ability, $arguments);
    }
}


function ErrorResponse($data, $message = "", $status = 400): JsonResponse
{
    return response()->json([
        'message' => $message,
        'errors' => $data
    ], $status);
}


function SuccessResponse($data, $message = "", $status = 200): JsonResponse
{
    return response()->json([
        'message' => $message,
        'data' => $data
    ], $status);
}


function unAuthorizedUserResponse(string $errorMessage = ''): JsonResponse
{
    $msg = $errorMessage ?: 'You aren\'t authorized to access this resource.';
    return response()->json(['message' => $msg], Response::HTTP_FORBIDDEN);
}

  