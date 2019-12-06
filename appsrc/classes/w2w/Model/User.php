<?php

namespace w2w\Model;

use DateTime;
use \w2w\Model\Role;

class User
{
    const TOSTRING_FORMAT = "User#%d (userName='%s', email='%s', emailVerified=%s, passwordHash='%s', 'firstName='%s', lastName='%s', createdAt='%s', updatedAt='%s', lastLoginAt='%s', banned=%s, numberReviews=%d, role=[%s])";
    const DEFAULT_DATETIME_FORMAT = "Y-m-d H:i:s";

    private $id;
    private $userName;
    private $email;
    private $emailVerified;
    private $passwordHash;
    private $firstName;
    private $lastName;
    private $createdAt;
    private $updatedAt;
    private $lastLoginAt;
    private $banned;
    private $numberReviews;
    private $role;

    /**
     * User constructor.
     * @param int $id
     * @param string $userName
     * @param string $email
     * @param bool $emailVerified
     * @param string $passwordHash
     * @param string $firstName
     * @param string $lastName
     * @param DateTime $createdAt
     * @param DateTime $updatedAt
     * @param DateTime $lastLoginAt
     * @param bool $banned
     * @param int $numberReviews
     * @param Role $role
     */
    public function __construct(
        int $id = null, 
        string $userName = null, 
        string $email = null, 
        bool $emailVerified = null, 
        string $passwordHash = null, 
        string $firstName = null, 
        string $lastName = null, 
        DateTime $createdAt = null, 
        DateTime $updatedAt = null, 
        DateTime $lastLoginAt = null, 
        bool $banned = null, 
        int $numberReviews = null,
        Role $role = null
    ) {
        $this->id = $id;
        $this->userName = $userName;
        $this->email = $email;
        $this->emailVerified = $emailVerified;
        $this->passwordHash = $passwordHash;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->lastLoginAt = $lastLoginAt;
        $this->banned = $banned;
        $this->numberReviews = $numberReviews;
        $this->role = $role;
    }

    public function __toString()
    {
        return sprintf(
            self::TOSTRING_FORMAT, 
            $this->id, 
            $this->userName, 
            $this->email,
            $this->emailVerified,
            $this->passwordHash,
            $this->firstName,
            $this->lastName,
            $this->createdAt ? $this->createdAt->format(self::DEFAULT_DATETIME_FORMAT) : null,
            $this->updatedAt ? $this->updatedAt->format(self::DEFAULT_DATETIME_FORMAT) : null,
            $this->lastLoginAt ? $this->lastLoginAt->format(self::DEFAULT_DATETIME_FORMAT) : null,
            $this->banned,
            $this->numberReviews,
            $this->role
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return bool
     */
    public function isEmailVerified(): bool
    {
        return $this->emailVerified;
    }

    /**
     * @param bool $emailVerified
     */
    public function setEmailVerified(bool $emailVerified): void
    {
        $this->emailVerified = $emailVerified;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @param string $passwordHash
     */
    public function setPasswordHash(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return DateTime
     */
    public function getLastLoginAt(): DateTime
    {
        return $this->lastLoginAt;
    }

    /**
     * @param DateTime $lastLoginAt
     */
    public function setLastLoginAt(DateTime $lastLoginAt): void
    {
        $this->lastLoginAt = $lastLoginAt;
    }

    /**
     * @return bool
     */
    public function isBanned(): bool
    {
        return $this->banned;
    }

    /**
     * @param bool $banned
     */
    public function setBanned(bool $banned): void
    {
        $this->banned = $banned;
    }

    /**
     * @return int
     */
    public function getNumberReviews(): int
    {
        return $this->numberReviews;
    }

    /**
     * @param int $numberReviews
     */
    public function setNumberReviews(int $numberReviews): void
    {
        $this->numberReviews = $numberReviews;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @param Role $role
     */
    public function setRole(Role $role = null): void
    {
        $this->role = $role;
    }

}
