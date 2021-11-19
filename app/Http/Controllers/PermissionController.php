<?php

namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Http\Resources\Permission\ViewPermissionResource;
use App\Http\Resources\Role\ViewRoleResource;
use App\Http\Resources\User\ViewUserResource;
use App\Services\PermissionService;
 

class PermissionController extends Controller
{
    /**@var PermissionService $permissionService */
    public PermissionService $permissionService;

    /**
     * __constructor
     *
     * @param PermissionService $permissionService
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * List all permissions
     *
     * @return void
     */
    public function index()
    {
        // Authorize permission
        Authorize('list-permissions');

        // get list of permissions
        $Permissions = $this->permissionService->list();

        // send json response
        return SuccessResponse(ViewPermissionResource::collection($Permissions), 'Retrieved Successfully');
    }

    /**
     * Store a new permission
     *
     * @return void
     */
    public function store()
    {
        // Authorize permission
        Authorize('list-permissions');

        // validate request
        $this->validate(request(), [
            'name' => 'required|unique:permissions,name',

        ]);

        // create new permission
        $Permission = $this->permissionService->create(request()->all());

        // send json response
        return SuccessResponse(new ViewPermissionResource($Permission), 'Created Successfully');
    }

    /**
     * Assign a permission
     *
     * @return void
     */
    public function assignToRole()
    {
        // Authorize permission
        Authorize('list-permissions');

        // validate request
        $this->validate(request(), [
            'permission_id' => 'required|exists:permissions,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        // assign permission
        $role = $this->permissionService->assignPermissionToRole(request()->all());

        if(!$role) {
            return ErrorResponse([],'permission assigned before');
        }

        // send json response
        return SuccessResponse(new ViewRoleResource($role), 'Assigned Successfully');
    }

    /**
     * Assign a permission
     *
     * @return void
     */
    public function assignToUser()
    {
        // Authorize permission
        Authorize('list-permissions');

        // validate request
        $this->validate(request(), [
            'permission_id' => 'required|exists:permissions,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // assign permission
        $user = $this->permissionService->assignPermissionToUser(request()->all());
        if (!$user) {
            return ErrorResponse([], 'permission assigned before');
        }

        // send json response
        return SuccessResponse(new ViewUserResource($user), 'Assigned Successfully');
    }




 
    
}
