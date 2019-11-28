<?php


namespace w2w\Model;

use DateTime;

class Message
{
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $content;
    private $createdAt;
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
    public function __construct(int $id, string $lastName, string $email, string $content, DateTime $createdAt, bool $treated)
    {
        $this->id = $id;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->treated = $treated;
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