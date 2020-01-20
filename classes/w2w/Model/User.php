<?php

namespace w2w\Model;

use DateTime;
use \Doctrine\Common\Collections\ArrayCollection;
use \w2w\Model\Role;

/**
 * @Entity
 * @Table(name="users")
 */
class User
{
    const TOSTRING_FORMAT = "User#%d (userName='%s', email='%s', emailVerified=%s, passwordHash='%s', 'firstName='%s', lastName='%s', createdAt='%s', updatedAt='%s', lastLoginAt='%s', banned=%s, numberReviews=%d, role=[%s])";
    const DEFAULT_DATETIME_FORMAT = "Y-m-d H:i:s";

	/**
	 * @Id 
	 * @Column(type="integer") 
	 * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column(name="user_name", unique=true)
     */
    private $userName;

    /**
     * @Column(name="email", unique=true)
     */
    private $email;

    /**
     * @Column(name="email_verified", type="boolean")
     */
    private $emailVerified;

    /**
     * @Column(name="password_hash")
     */
    private $passwordHash;

    /**
     * @Column(name="first_name")
     */
    private $firstName;

    /**
     * @Column(name="last_name")
     */
    private $lastName;

    /**
     * @Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @Column(name="last_login_at", type="datetime", nullable=true)
     */
    private $lastLoginAt;

    /**
     * @Column(type="boolean", nullable=true)
     */
    private $banned;

    /**
     * @Column(name="number_reviews", type="integer", nullable=true)
     */
    private $numberReviews;

	/**
	 * @ManyToOne(targetEntity=\w2w\Model\Role::class) 
	 * @JoinColumn(name="fk_role_id", referencedColumnName="id")
	 */
    private $role;

    /**
     * @OneToMany(targetEntity="\w2w\Model\Review", mappedBy="user")
     * 
     * @Todo ajouter cette propriété au diagramme de classe
     */
    protected $reviews = [];

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
		$this->reviews = new ArrayCollection();
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
            $this->createdAt instanceof \DateTime ? $this->createdAt->format(self::DEFAULT_DATETIME_FORMAT) : null,
            $this->updatedAt instanceof \DateTime ? $this->updatedAt->format(self::DEFAULT_DATETIME_FORMAT) : null,
            $this->lastLoginAt instanceof \DateTime ? $this->lastLoginAt->format(self::DEFAULT_DATETIME_FORMAT) : null,
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

    public function getReviews()
    {
		return $this->reviews->toArray();
	}
    	
    public function addReview(Review $review)
    {
        if ($this->reviews->contains($review)) {
            return;
        }
        $this->reviews->add($review);
    }
    
    public function removeReview(Review $review)
    {
        if (! $this->reviews->contains($review)) {
            return;
        }
        $this->reviews->removeElement($review);
    }


    /**
     * Vrai si l'utilisateur est "admin" ou "root"
     * 
     * Appeler cette méthode "hasAdminRole" serait peut-être plus orthodoxe, mais serait plus long à écrire dans les vues
     */
    public function isAdmin() {
        if ($this->role && ($this->role->getName() === "admin" || $this->role->getName() === "root")) {
            return true;
        }
        return false;
    }

    /**
     * Vrai si l'utilisateur est "root"
     * 
     * Appeler cette méthode "hasRootRole" serait peut-être plus orthodoxe, mais serait plus long à écrire dans les vues
     */
    public function isRoot() {
        if ($this->role && $this->role->getName() === "root") {
            return true;
        }
        return false;
    }

}
