<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Enums\UserStatusEnum;
use App\Entities\User;
use phpDocumentor\Reflection\Types\Boolean;
use Modules\Company\Enums\CompanyStatusEnum;
use Modules\Company\Emails\CompanyVerifyMail;
use App\Jobs\SendEmailJob;
use Spatie\DataTransferObject\DataTransferObject;
use App\DTOs\Auth\ResetPasswordDTO;
use App\Mail\SetNewCompanyPassword;
use App\Repositories\UserRepository;
use App\Events\Auth\UserForgotPassword;
use App\DTOs\Auth\UserForgetPasswordDTO;

class AuthService
{
    /**@var UserRepository $userRepo user repository instance */
    public $userRepo;

    /**
     * Undocumented function
     *
     * @param UserRepository $userRepo
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function checkUserStatusBeforeLogin($email)
    {
        $user = $this->userRepo->getFirstModelWhere('email', $email);

        if(! $user) {
            return "Invalid credentials";
        }

        return true;
    }



    /**
     * validated user credentials and return token
     *
     * @param string $email
     * @param string $password
     * @return void
     */
    public function userLogin($email, $password)
    {
        if (!$token = auth()->attempt(['email' => $email, 'password' => $password])) {
            return false;
        }

        return $this->prepareToken($token);
    }

    /**
     * refersh user token
     *
     * @return void
     */
    public function refreshUserToken()
    {
        return $this->prepareToken(auth()->refresh());
    }

 

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    protected function prepareToken($token)
    {
        $currentUser = auth()->user();

        //$permissions = $currentUser->allPermissions()->pluck('name') ?? [];

 
        return [
            'id' => $currentUser->id,
            'name' => $currentUser->name,
            'email' => $currentUser->email,
            'permissions' => $permissions ?? [],
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60, 
        ];
    }

 
 
 
 
}
