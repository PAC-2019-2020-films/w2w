<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\RoleDAO;
use w2w\Model\Role;

class DoctrineRoleDAO extends DoctrineGenericDAO implements RoleDAO
{

    /**
     * @param string $name
     * @return bool|Role
     */
    public function findByName(string $name)
    {
    }
    
}
