<?php

namespace w2w\Model;

use DateTime;

/**
 * @Entity
 * @Table(name="reports")
 */
class Report
{
    const TOSTRING_FORMAT = "Report#%d (message='%s', createdAt='%s', treated=%s, user=[%s], review=[%s])";
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
    private $message;

    /**
     * @Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @Column(type="boolean")
     */
    private $treated;

	/**
	 * @ManyToOne(targetEntity=\w2w\Model\User::class)
	 * @JoinColumn(name="fk_user_id", referencedColumnName="id")
	 */
    private $user;

	/**
	 * @ManyToOne(targetEntity=\w2w\Model\Review::class)
	 * @JoinColumn(name="fk_review_id", referencedColumnName="id")
	 */
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
    public function __construct(int $id = null, string $message = null, DateTime $createdAt = null, bool $treated = null, User $user = null, Review $review = null)
    {
        $this->id = $id;
        $this->message = $message;
        $this->createdAt = $createdAt;
        $this->treated = $treated;
        $this->user = $user;
        $this->review = $review;
    }

    public function __toString()
    {
        return sprintf(
            self::TOSTRING_FORMAT, 
            $this->id, 
            $this->message, 
            $this->createdAt instanceof \DateTime ? $this->createdAt->format(self::DEFAULT_DATETIME_FORMAT) : null,
            $this->treated,
            $this->user,
            $this->review
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
