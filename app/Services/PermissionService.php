<?php

namespace App\Services;
 
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;

class PermissionService
{
    /**@var PermissionRepository $permissionRepo permission repository instance */
    public $permissionRepo;
    /**@var RoleRepository $roleRepo role repository instance */
    public $roleRepo;
    /**@var UserRepository $userRepo user repository instance */
    public $userRepo;

    /**
     * __construct function
     *
     * @param PermissionRepository $permissionRepo
     * @param RoleRepository $roleRepo
     * @param UserRepository $userRepo
     */
    public function __construct(PermissionRepository $permissionRepo, RoleRepository $roleRepo, UserRepository $userRepo)
    {
        $this->permissionRepo = $permissionRepo;
        $this->roleRepo = $roleRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * List permissions
     *
     *  
     * @return collection
     */
    public function list()
    {
        return $this->permissionRepo->all();
    }


    /**
     * Create a new permission
     *
     * @param array $data
     * @return Permission
     */
    public function create(array $data)
    {
        return $this->permissionRepo->create(['name' => $data['name']]);
    }
 
  

    /**
     * Assign a permission to a role
     *
     * @param array $data
     * @return Role
     */
    public function assignPermissionToRole(array $data)
    {
        $permission = $this->permissionRepo->find($data['permission_id']);
        $role = $this->roleRepo->find($data['role_id']);

        if($role->hasPermissionTo($permission)){
            return false;
        };

        $role->givePermissionTo($permission);

        return $role;
    }


    /**
     * Assign a permission to a User
     *
     * @param array $data
     * @return User
     */
    public function assignPermissionToUser(array $data)
    {
        $permission = $this->permissionRepo->find($data['permission_id']);
        $user = $this->userRepo->find($data['user_id']);

        if ($user->hasPermissionTo($permission)) {
            return false;
        };

        $user->givePermissionTo($permission);

        return $user;
    }

 
 
 
}
