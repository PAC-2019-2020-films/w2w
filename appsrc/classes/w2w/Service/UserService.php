<?php
namespace w2w\Service;

use \w2w\Model\User;

class UserService extends PublicService
{
    
    public function __construct(User $user)
    {
        parent::__construct($user);
        if (! $user) {
            throw new \Exception("Can't instantiate service with null User ");
        }
    }
        
}
