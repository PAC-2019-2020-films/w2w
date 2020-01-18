<?php

namespace w2w\DAO;

use w2w\Model\Role;

interface RoleDAO extends GenericDAO
{

    /**
     * @param string $name
     * @return bool|Role
     */
    public function findByName(string $name) : ?Role;
    
}
