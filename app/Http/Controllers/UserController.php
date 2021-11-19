<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\DTOs\UserDTO;
use App\Entities\User;
use App\Services\UserService;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Requests\User\ListUsersRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Resources\User\ViewUserResource;
use App\Http\Resources\User\ListUsersResource;
use App\Http\Requests\User\UserChangePasswordRequest;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    /**@var UserService $userService */
    public UserService $userService;
    public UserRepository $userRepo;

    /**
     * __constructor
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService, UserRepository $userRepo)
    {
        $this->userService = $userService;
        $this->userRepo = $userRepo;
    }

    /**
     * List all users
     *
     * @return void
     */
    public function index()
    {
        // Authorize user
        Authorize('viewAny', User::class);

        // get list of users
        $Users = $this->userService->list();

        // send json response
        return response()->json(['message' => 'Retrieved Successfully', 'data' => ViewUserResource::collection($Users)], Response::HTTP_OK);
    }

 
    /**
     * Get user details
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        // authorize user
        Authorize('view', User::class);

        try {
            $user = $this->userService->getUser($id);
            return response()->json(['message' => 'Retrieved Successfully', 'data' => new ViewUserResource($user)], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'User not found.'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Edit user data
     *
     * @param int $id
     * @param EditUserRequest $request
     * @return void
     */
    public function edit($id, EditUserRequest $request)
    {
        // Authorize user
        Authorize('edit', User::class);

        try {
            $updatedKeys = array_keys($request->all());
            // prepare user dto data
            $userDto = UserDTO::fillUserDto($request->except(['status']))->only(...$updatedKeys);
            // edit user
            $this->userService->editUser($userDto);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something wrong.', 'errors' => [$e->getMessage()]], Response::HTTP_EXPECTATION_FAILED);
        }

        return response()->json(['message' => 'Updated Successfully'], Response::HTTP_CREATED);
    }

    public function changePassword(UserChangePasswordRequest $request)
    {
        $user_model = $this->userRepo->find($request->user_id);
        Authorize('updatePassword', $user_model);
        try {
            $user_model = $this->userService->changePassword($user_model, $request->password);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }

        return response()->json(['message' => 'Updated Successfully']);
    }

    /**
     * Activate user
     */
    public function activateUser($id)
    {
        // authorize user
        Authorize('activateUser', User::class);

        try {
            $this->userService->activateUser($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something wrong.', 'errors' => [$e->getMessage()]], Response::HTTP_EXPECTATION_FAILED);
        }
        return response()->json(['message' => 'Activated Successfully'], Response::HTTP_OK);
    }

    /**
     * Deactivate user
     */
    public function deactivateUser($id)
    {
        // authorize user
        Authorize('deactivateUser', User::class);

        try {
            $this->userService->deactivateUser($id);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something wrong.', 'errors' => [$e->getMessage()]], Response::HTTP_EXPECTATION_FAILED);
        }
        return response()->json(['message' => 'Deactivated Successfully'], Response::HTTP_OK);
    }
}
