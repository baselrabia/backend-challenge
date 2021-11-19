<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Response;
use App\Models\User as Admin;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;


class LoginController extends Controller
{
    /**@var AuthService $authSerfvice instance of auth service */
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
            $user = Admin::query()->where('email', $request->email)->first();
            Event::dispatch(new Failed('api', $user, []));

            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        Event::dispatch(new Login('api', auth()->user(), false));
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


    public function resendVerifyEmail($email)
    {
        try {
            return $this->authService->resendVerificationEmail($email);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something wrong.', 'errors' => [$e->getMessage()]], Response::HTTP_EXPECTATION_FAILED);
        }
    }

    public function verifyEmail($email, $code)
    {
        try {
            $verified = $this->authService->verifyEmail($email, $code);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something wrong.', 'errors' => [$e->getMessage()]], Response::HTTP_EXPECTATION_FAILED);
        }
        return redirect(config('app.front_url') . ($verified ? '/confirmed' : '/not-confirmed'));
    }
}