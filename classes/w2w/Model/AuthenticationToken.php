<?php

namespace w2w\Model;

use DateTime;
use \w2w\Model\User;

/**
 * @Entity
 * @Table(name="authentication_tokens")
 */
class AuthenticationToken
{
    const TOSTRING_FORMAT = "AuthenticationToken#%d (email='%s', token='%s', expiresAt='%s', verifiedAt='%s', newPassword='%s', user=%s)";
    const DEFAULT_DATETIME_FORMAT = "Y-m-d H:i:s";

	/**
	 * @Id 
	 * @Column(type="integer") 
	 * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column
     */
    private $email;

    /**
     * @Column
     */
    private $token;

    /**
     * @Column(name="expires_at", type="datetime")
     */
    private $expiresAt;

    /**
     * @Column(name="verified_at", type="datetime")
     */
    private $verifiedAt;

    /**
     * @Column(name="new_password", type="boolean", nullable=true);
     */
    private $newPassword;

	/**
	 * @ManyToOne(targetEntity=\w2w\Model\User::class) 
	 * @JoinColumn(name="fk_user_id", referencedColumnName="id")
	 */
    private $user;

    /**
     * AuthenticationToken constructor.
     * @param int $id
     * @param string $email
     * @param string $token
     * @param DateTime $expiresAt
     * @param bool $newPassword
     * @param User $user
     */
    public function __construct(int $id = null, string $email = null, string $token = null, DateTime $expiresAt = null, DateTime $verifiedAt = null, bool $newPassword = null, User $user = null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->token = $token;
        $this->expiresAt = $expiresAt;
        $this->verifiedAt = $verifiedAt;
        $this->newPassword = $newPassword;
        $this->user = $user;
    }

    public function __toString()
    {
        return sprintf(
            self::TOSTRING_FORMAT, 
            $this->id, 
            $this->email,
            $this->token,
            $this->expiresAt instanceof \DateTime ? $this->expiresAt->format(self::DEFAULT_DATETIME_FORMAT) : null,
            $this->verifiedAt instanceof \DateTime ? $this->verifiedAt->format(self::DEFAULT_DATETIME_FORMAT) : null,
            $this->newPassword,
            $this->user
        );
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
