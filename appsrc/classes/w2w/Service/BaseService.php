<?php
namespace w2w\Service;

use \w2w\DAO\RoleDAO;
use \w2w\DAO\UserDAO;
use \w2w\Model\Role;
use \w2w\Model\User;

class BaseService
{
    
    protected $serviceUser;
    protected $roleDAO;
    protected $userDAO;
    
    public function __construct(User $user = null)
    {
        $this->serviceUser = $user;
    }
    
    public function hasServiceUser()
    {
        return $this->serviceUser != null;
    }

    public function getServiceUser()
    {
        return $this->serviceUser;
    }

    public function getRoleDAO()
    {
        if (! $this->roleDAO) {
            $this->roleDAO = new RoleDAO();
        }
        return $this->roleDAO;
    }
    
    public function getUserDAO()
    {
        if (! $this->userDAO) {
            $this->userDAO = new UserDAO();
        }
        return $this->userDAO;
    }
        
}
