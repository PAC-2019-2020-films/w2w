<?php

namespace w2w\Model;

use DateTime;

/**
 * @Entity
 * @table(name="reviews")
 */
class Review
{
    const TOSTRING_FORMAT = "Review#%d (content='%s', createdAt='%s', updatedAt='%s', movie=[%s], user=[%s], rating=[%s])";
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
    private $content;

    /**
     * @Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

	/**
	 * @ManyToOne(targetEntity=\w2w\Model\Movie::class)
	 * @JoinColumn(name="fk_movie_id", referencedColumnName="id")
	 */
    private $movie;

	/**
	 * @ManyToOne(targetEntity=\w2w\Model\User::class)
	 * @JoinColumn(name="fk_user_id", referencedColumnName="id")
	 */
    private $user;

	/**
	 * @ManyToOne(targetEntity=\w2w\Model\Rating::class)
	 * @JoinColumn(name="fk_rating_id", referencedColumnName="id")
	 */
    private $rating;

    /**
     * Review constructor.
     * @param int $id
     * @param string $content
     * @param DateTime $createdAt
     * @param Movie $movie
     * @param User $user
     * @param Rating $rating
     */
    public function __construct(int $id = null, string $content = null, DateTime $createdAt = null, DateTime $updatedAt = null, Movie $movie = null, User $user = null, Rating $rating = null)
    {
        $this->id = $id;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->movie = $movie;
        $this->user = $user;
        $this->rating = $rating;
    }

    public function __toString()
    {
        return sprintf(
            self::TOSTRING_FORMAT, 
            $this->id, 
            $this->content, 
            $this->createdAt instanceof \DateTime ? $this->createdAt->format(self::DEFAULT_DATETIME_FORMAT) : null,
            $this->updatedAt instanceof \DateTime ? $this->updatedAt->format(self::DEFAULT_DATETIME_FORMAT) : null,
            $this->movie,
            $this->user,
            $this->rating
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
     * @return Movie
     */
    public function getMovie(): Movie
    {
        return $this->movie;
    }

    /**
     * @param Movie $movie
     */
    public function setMovie(Movie $movie): void
    {
        $this->movie = $movie;
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
     * @return Rating
     */
    public function getRating(): Rating
    {
        return $this->rating;
    }

    /**
     * @param Rating $rating
     */
    public function setRating(Rating $rating): void
    {
        $this->rating = $rating;
    }


}
