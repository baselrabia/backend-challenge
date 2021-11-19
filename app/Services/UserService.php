<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\Eloquent\Builder;
use App\DTOs\UserDTO;
use App\Models\User;
use phpDocumentor\Reflection\Types\Boolean;
use App\Models\UserType;
use App\DTOs\Auth\ResetPasswordDTO;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Enums\UserStatusEnum;
use Illuminate\Http\Response;
use App\Repositories\UserRepository;
use App\Events\Auth\UserForgotPassword;
use App\DTOs\Auth\UserForgetPasswordDTO;
use App\Mail\Auth\SendForgetPasswordMail;

class UserService
{
    /**@var UserRepository $userRepo user repository instance */
    public $userRepo;

    /**
     * __construct function
     *
     * @param UserRepository $userRepo
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * List users
     *
     *  
     * @return collection
     */
    public function list()
    {
        return $this->userRepo->all();
    }

 
  

 
 
 
}
