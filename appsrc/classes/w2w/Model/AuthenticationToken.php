<?php


namespace w2w\Model;

use DateTime;
use \w2w\Model\User;

class AuthenticationToken
{
    private $id;
    private $email;
    private $token;
    private $expiresAt;
    private $verifiedAt;
    private $newPassword;
    private $user;

    /**
     * AuthenticationToken constructor.
     * @param int $id
     * @param string $email
     * @param string $token
     * @param DateTime $expiresAt
     * @param string $newPassword
     * @param User $user
     */
    public function __construct(int $id, string $email, string $token, DateTime $expiresAt, string $newPassword, User $user)
    {
        $this->id = $id;
        $this->email = $email;
        $this->token = $token;
        $this->expiresAt = $expiresAt;
        $this->newPassword = $newPassword;
        $this->user = $user;
    }


    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
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
     * @return DateTime
     */
    public function getExpiresAt(): DateTime
    {
        return $this->expiresAt;
    }

    /**
     * @param DateTime $expiresAt
     */
    public function setExpiresAt(DateTime $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return bool|DateTime
     */
    public function getVerifiedAt()
    {
        return $this->verifiedAt;
    }

    /**
     * @param DateTime $verifiedAt
     */
    public function setVerifiedAt(DateTime $verifiedAt): void
    {
        $this->verifiedAt = $verifiedAt;
    }

    /**
     * @return string
     */
    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    /**
     * @param string $newPassword
     */
    public function setNewPassword(string $newPassword): void
    {
        $this->newPassword = $newPassword;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }




}