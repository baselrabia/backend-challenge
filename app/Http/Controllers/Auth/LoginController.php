<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /**@var AuthService $authService instance of auth service */
    public AuthService $authService;

    /**
     * __constructor
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * central app user login.
     * 
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        $check_allowed_status = $this->authService->checkUserStatusBeforeLogin($request->email);
        if($check_allowed_status !== true) {
            return response(['message' => 'Unauthorized', 'data' => $check_allowed_status], Response::HTTP_UNAUTHORIZED);
        }
        
        if (! $token = $this->authService->userLogin($request->email, $request->password)) {
             return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(['message' => 'Logged in successfully.', 'data' => $token]);
    }

    /**
     * Refresh user token for central app.
     */
    public function refreshToken()
    {
        $token = $this->authService->refreshUserToken();
        return response()->json(['message' => 'Token retrieved Successfully.', 'data' => $token]);
    }

    /**
     * logout user 
     *
     * @return void
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out.']);
    }



}