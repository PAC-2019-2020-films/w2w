<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\UserDAO;
use w2w\Model\Role;
use w2w\Model\User;
use w2w\Model\AuthenticationToken;

class DoctrineUserDAO extends DoctrineGenericDAO implements UserDAO
{
    
    public function __construct()
    {
        parent::__construct(User::class);
    }

    /**
     * @param string $email
     * @return bool|User
     */
    public function findByEmail(string $email): ?User
    {
        return $this->findOneBy("email", $email);
    }

    /**
     * @param string $userName
     * @return bool|User
     */
    public function findByUserName(string $userName): ?User
    {
        return $this->findOneBy("userName", $userName);
    }

    /**
     * @param AuthenticationToken $authToken
     * @return bool|User
     */
    public function findByToken(AuthenticationToken $authToken)
    {
    }

    /**
     * @param Role $role
     * @return bool|User[]
     */
    public function findByRole(Role $role): array
    {
    }

    /**
     * @param bool $banned
     * @return bool|User[]
     */
    public function findByBanned(bool $banned): array
    {
        return $this->findBy("banned", $email);
    }

}
