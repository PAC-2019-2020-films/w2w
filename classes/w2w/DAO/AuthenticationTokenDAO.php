<?php

namespace w2w\DAO;

use w2w\Model\User;

interface AuthenticationTokenDAO extends GenericDAO
{
    
    public function findByUser(User $user);
    
}
