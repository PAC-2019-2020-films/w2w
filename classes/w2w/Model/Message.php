<?php

namespace w2w\Model;

use DateTime;

/**
 * @Entity
 * @Table(name="messages")
 */
class Message
{
    const TOSTRING_FORMAT = "Message#%d (firstName='%s', lastName='%s', email='%s', content='%s', createdAt='%s', treated=%s)";
    const DEFAULT_DATETIME_FORMAT = "Y-m-d H:i:s";

	/**
	 * @Id 
	 * @Column(type="integer") 
	 * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @Column(name="first_name")
     */
    private $firstName;

    /**
     * @Column(name="last_name")
     */
    private $lastName;

    /**
     * @Column
     */
    private $email;

    /**
     * @Column
     */
    private $content;

    /**
     * @Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @Column(type="boolean")
     */
    private $treated;

    /**
     * Message constructor.
     * @param int $id
     * @param string $lastName
     * @param string $email
     * @param string $content
     * @param DateTime $createdAt
     * @param bool $treated
     */
    public function __construct(int $id = null, string $firstName = null, string $lastName = null, string $email = null, string $content = null, DateTime $createdAt = null, bool $treated = null)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->treated = $treated;
    }

    public function __toString()
    {
        return sprintf(
            self::TOSTRING_FORMAT, 
            $this->id, 
            $this->firstName,
            $this->lastName,
            $this->email,
            $this->content,
            $this->createdAt instanceof \DateTime ? $this->createdAt->format(self::DEFAULT_DATETIME_FORMAT) : null,
            $this->treated
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
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
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
     * @return bool
     */
    public function isTreated(): bool
    {
        return $this->treated;
    }

    /**
     * @param bool $treated
     */
    public function setTreated(bool $treated): void
    {
        $this->treated = $treated;
    }

}
