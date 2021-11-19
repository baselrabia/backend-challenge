<?php

namespace App\Services;
 
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;

class RoleService
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
     * List roles
     *
     *  
     * @return collection
     */
    public function list()
    {
        return $this->roleRepo->all();
    }


    /**
     * Create a new role
     *
     * @param array $data
     * @return Role
     */
    public function create(array $data)
    {
        
        $role = $this->roleRepo->create(['name' => $data['name']]);

        $role->givePermissionTo($data['permissions']);

        return $role;

    }
 
  


    /**
     * Assign a role to a User
     *
     * @param array $data
     * @return User
     */
    public function assignRoleToUser(array $data)
    {
        $role = $this->roleRepo->find($data['role_id']);
        $user = $this->userRepo->find($data['user_id']);

        if ($user->hasRole($role)) {
            return false;
        };

        $user->assignRole($role);

        return $user;
    }

 
 
 
}
