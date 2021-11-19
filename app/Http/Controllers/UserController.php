<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Http\Resources\User\ViewUserResource;

class UserController extends Controller
{
    /**@var UserService $userService */
    public UserService $userService;

    /**
     * __constructor
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * List all users
     *
     * @return void
     */
    public function index()
    {
        // Authorize user
        Authorize('list-users');

        // get list of users
        $Users = $this->userService->list();

        // send json response
        return SuccessResponse(ViewUserResource::collection($Users), 'Retrieved Successfully');
    }
 
    
}
