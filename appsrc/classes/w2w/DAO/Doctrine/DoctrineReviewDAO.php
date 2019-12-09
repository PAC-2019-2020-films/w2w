<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\ReviewDAO;
use w2w\Model\Movie;
use w2w\Model\Review;
use w2w\Model\User;

class DoctrineReviewDAO extends DoctrineGenericDAO implements ReviewDAO
{
    
    public function __construct()
    {
        parent::__construct(Review::class);
    }

    /**
     * @param Movie $movie
     * @return bool|Review[]
     */
    public function findByMovie(Movie $movie)
    {
    }
    
    /**
     * @param User $user
     * @return bool|Review[]
     */
    public function findByUser(User $user)
    {
    }
    
}
