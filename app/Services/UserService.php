<?php

namespace App\Services;

use App\Repositories\UserRepository;
 
class UserService
{
    /**@var UserRepository $userRepo user repository instance */
    public $userRepo;

    /**
     * __construct function
     *
     * @param UserRepository $userRepo
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * List users
     *
     *  
     * @return collection
     */
    public function list()
    {
        return $this->userRepo->all();
    }

 
  

 
 
 
}
