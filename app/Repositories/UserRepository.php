<?php

namespace App\Repositories;

use App\Models\User;
 

class UserRepository extends BaseRepository
{
    /**
     * __constructor
     *
     * @param User $userModel
     */
    public function __construct(User $userModel)
    {
        parent::__construct($userModel);
    }

    
}
