<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\AuthenticationTokenDAO;
use w2w\Model\User;

class DoctrineAuthenticationTokenDAO extends DoctrineGenericDAO implements AuthenticationTokenDAO
{
    
    public function findByUser(User $user)
    {
    }
    
}
