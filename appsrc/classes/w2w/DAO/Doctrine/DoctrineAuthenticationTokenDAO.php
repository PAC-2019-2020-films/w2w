<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\AuthenticationTokenDAO;
use w2w\Model\AuthenticationToken;
use w2w\Model\User;

class DoctrineAuthenticationTokenDAO extends DoctrineGenericDAO implements AuthenticationTokenDAO
{
    
    public function __construct()
    {
        parent::__construct(AuthenticationToken::class);
    }

    public function findByUser(User $user)
    {
    }
    
}
