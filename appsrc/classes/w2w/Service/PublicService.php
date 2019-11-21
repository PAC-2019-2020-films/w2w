<?php
namespace w2w\Service;

use \w2w\DAO\RoleDAO;
use \w2w\DAO\UserDAO;
use \w2w\Model\Role;
use \w2w\Model\User;

class PublicService extends BaseService
{
    
    public function __construct(User $user = null)
    {
        parent::__construct($user);
    }
    
    public function getRoles()
    {
        return $this->getRoleDAO()->selectAll();
    }
    
    public function getRole($id)
    {
        return $this->getRoleDAO()->select($id);
    }
    
    public function getUsers()
    {
        return $this->getUserDAO()->selectAll();
    }
    
    public function getUser($id)
    {
        return $this->getUserDAO()->select($id);
    }
    
    
    /**
     * renvoie objet User correspondant si existe
     */
    public function login($email, $password)
    {
        if ($user = $this->getUserDAO()->selectByEmail($email)) {
            if (password_verify($password, $user->getPasswordHash())) {
                return $user;
            }
        }
        return false;
    }
    
    /**
     * ajoute un User à l'email non vérifié
     * (pas d'envoi par email de token de vérification pour le moment)
     */
    public function addUser($userName, $email, $password, $roleId, $firstName = null, $lastName = null)
    {
        $role = $this->getRole($roleId);
        if (! $role instanceof Role) {
            throw new \Exception("Role not found");
        }
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $len = strlen($passwordHash);
        $user = new User();
        $user->setUserName($userName);
        $user->setEmail($email);
        $user->setEmailVerified(false);
        $user->setPasswordHash($passwordHash);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setCreatedAt(time());
        $user->setUpdatedAt(null);
        $user->setLastLoginAt(null);
        $user->setBanned(false);
        $user->setNumberReviews(0);
        $user->setRole($role);
        $id = $this->getUserDAO()->insert($user);
        return $id;
    }
    
    /**
     * @todo à déplacer dans service adéquat
     */
    public function updateUser($id, $firstName, $lastName)
    {
        $user = $this->getUserDAO()->select($id);
        if (! $user) {
            throw new \Exception("User to update not found ($id)");
            return false;
        }
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setUpdatedAt(time());
        $affectedRows = $this->getUserDAO()->update($user);
        echo "Service : updateds $id : $affectedRows- $user \n";
        return $affectedRows;
    }
    
}
