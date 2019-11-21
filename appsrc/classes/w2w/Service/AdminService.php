<?php
namespace w2w\Service;

use \w2w\Model\User;

class AdminService extends UserService
{
    
    public function __construct(User $user)
    {
        parent::__construct($user);
        if (! $user->isAdmin()) {
            throw new \Exception("Can't instantiate service with non admin User ");
        }
    }
    
}
