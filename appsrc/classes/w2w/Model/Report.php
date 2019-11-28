<?php


namespace w2w\Model;

use DateTime;

class Report
{
    private $id;
    private $message;
    private $createdAt;
    private $treated;
    private $user;
    private $review;

    /**
     * Report constructor.
     * @param int $id
     * @param string $message
     * @param DateTime $createdAt
     * @param bool $treated
     * @param User $user
     * @param Review $review
     */
    public function __construct(int $id, string $message, DateTime $createdAt, bool $treated, User $user, Review $review)
    {
        $this->id = $id;
        $this->message = $message;
        $this->createdAt = $createdAt;
        $this->treated = $treated;
        $this->user = $user;
        $this->review = $review;
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
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
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

    /**
     * @return Review
     */
    public function getReview(): Review
    {
        return $this->review;
    }

    /**
     * @param Review $review
     */
    public function setReview(Review $review): void
    {
        $this->review = $review;
    }


}