<?php


namespace w2w\Model;

use DateTime;

class Review
{
    private $id;
    private $content;
    private $createdAt;
    private $updatedAt;
    private $movie;
    private $user;
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
    public function __construct(int $id, string $content, DateTime $createdAt, Movie $movie, User $user, Rating $rating)
    {
        $this->id = $id;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->movie = $movie;
        $this->user = $user;
        $this->rating = $rating;
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