<?php
namespace w2w\Service;

use \w2w\Model\User;

class RootService extends AdminService
{
    
    public function __construct(User $user)
    {
        parent::__construct($user);
        if (! $user->isRoot()) {
            throw new \Exception("Can't instantiate service with non root User ");
        }
    }
        
}
