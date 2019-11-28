<?php


namespace w2w\Service;


use \w2w\Model\Movie;
use \w2w\Model\Review;
use \w2w\Model\User;

class ReviewPublicService extends PublicService
{

    /**
     * ReviewPublicService constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    

    /**
     * getAllReviews
     * @return Review[]
     */
    public function getAllReviews(): array
    {
        return $this->reviewDAO->selectAllReviews();
    }

    /**
     * @param int $id
     * @return Review
     */
    public function getReviewById(int $id): Review
    {
        return $this->reviewDAO->selectReviewById($id);
    }

    /**
     * getReviewsByMovie
     * @param Movie $movie
     * @return Review[]
     */
    public function getReviewsByMovie(Movie $movie): array
    {
        return $this->reviewDAO->selectReviewsByMovie($movie);
    }

    /**
     * getReviewsByUser
     * @param User $user
     * @return Review[]
     */
    public function getReviewsByUser(User $user):array
    {
        return $this->reviewDAO->selectReviewsByUser($user);
    }

}