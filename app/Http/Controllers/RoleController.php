<?php

namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Http\Resources\Role\ViewRoleResource;
use App\Http\Resources\User\ViewUserResource;
use App\Models\Permission;
use App\Services\RoleService;
 

class RoleController extends Controller
{
    /**@var RoleService $roleService */
    public RoleService $roleService;

    /**
     * __constructor
     *
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * List all roles
     *
     * @return void
     */
    public function index()
    {        
        // Authorize role
        Authorize('list-roles');

        // get list of roles
        $Roles = $this->roleService->list();

        // send json response
        return SuccessResponse(ViewRoleResource::collection($Roles), 'Retrieved Successfully');
    }

    /**
     * Store a new role
     *
     * @return void
     */
    public function store()
    {
        // Authorize role
        Authorize('list-roles');

        // validate request
        $this->validate(request(), [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,id',

        ]);

        // create new role
        $Role = $this->roleService->create(request()->all());

        // send json response
        return SuccessResponse(new ViewRoleResource($Role), 'Created Successfully');
    }

   

    /**
     * Assign a role
     *
     * @return void
     */
    public function assignToUser()
    {
        // Authorize role
        Authorize('list-roles');

        // validate request
        $this->validate(request(), [
            'role_id' => 'required|exists:roles,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // assign role
        $user = $this->roleService->assignRoleToUser(request()->all());
        if (!$user) {
            return ErrorResponse([], 'role assigned before');
        }

        // send json response
        return SuccessResponse(new ViewUserResource($user), 'Assigned Successfully');
    }




 
    
}
