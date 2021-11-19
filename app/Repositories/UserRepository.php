<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use App\Models\UserType;

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
