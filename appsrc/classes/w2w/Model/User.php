<?php
namespace w2w\Model;

class User
{

    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;
    const ROLE_ROOT = 3;
    
    protected $id;
    protected $userName;
    protected $email;
    protected $emailVerified;
    protected $passwordHash;
    protected $firstName;
    protected $lastName;
    protected $createdAt;
    protected $updatedAt;
    protected $lastLoginAt;
    protected $banned;
    protected $numberReviews;
    protected $role;
    
    
    public function __construct()
    {
    }

    public function __toString()
    {
        return sprintf("User#%d (userName='%s', email='%s', role={%s})", 
            $this->id,
            $this->userName,
            $this->email,
            $this->role
        );
    }

    public function isAdmin()
    {
        if ($this->role instanceof Role) {
            $roleId = $this->role->getId();
            if ($roleId == self::ROLE_ADMIN || $roleId == self::ROLE_ROOT) {
                return true;
            }
        }
        return false;
    }
    
    public function isRoot()
    {
        if ($this->role instanceof Role) {
            $roleId = $this->role->getId();
            if ($roleId == self::ROLE_ROOT) {
                return true;
            }
        }
        return false;
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    public function getUserName()
    {
        return $this->userName;
    }
    
    public function setUserName($userName)
    {
        $this->userName = $userName;
        return $this;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    
    public function getEmailVerified()
    {
        return $this->emailVerified;
    }
    
    public function setEmailVerified($emailVerified)
    {
        $this->emailVerified = $emailVerified;
        return $this;
    }
    
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }
    
    public function setPasswordHash($passwordHash)
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }
    
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }
    
    public function getLastName()
    {
        return $this->lastName;
    }
    
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }
    
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }
    
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
    
    public function getLastLoginAt()
    {
        return $this->lastLoginAt;
    }
    
    public function setLastLoginAt($lastLoginAt)
    {
        $this->lastLoginAt = $lastLoginAt;
        return $this;
    }
    
    public function isBanned()
    {
        return $this->banned;
    }
    
    public function setBanned($banned = true)
    {
        $this->banned = $banned;
        return $this;
    }
    
    public function getNumberReviews()
    {
        return $this->numberReviews;
    }
    
    public function setNumberReviews($numberReviews)
    {
        $this->numberReviews = $numberReviews;
        return $this;
    }
    
    public function getRole()
    {
        return $this->role;
    }
    
    public function setRole(Role $role)
    {
        $this->role = $role;
        return $this;
    }
    
}
