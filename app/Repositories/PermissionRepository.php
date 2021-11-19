<?php

namespace App\Repositories;

use App\Models\Permission;
 

class PermissionRepository extends BaseRepository
{
    /**
     * __constructor
     *
     * @param Permission $permissionModel
     */
    public function __construct(Permission $permissionModel)
    {
        parent::__construct($permissionModel);
    }

    
}
