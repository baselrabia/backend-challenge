<?php

namespace App\Repositories;

use App\Models\Role;
 

class RoleRepository extends BaseRepository
{
    /**
     * __constructor
     *
     * @param Role $roleModel
     */
    public function __construct(Role $roleModel)
    {
        parent::__construct($roleModel);
    }

    
}
