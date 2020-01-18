<?php

namespace w2w\DAO;

use w2w\Model\Movie;
use w2w\Model\Review;
use w2w\Model\User;

interface ReviewDAO extends GenericDAO
{
    
    /**
     * @param Movie $movie
     * @return bool|Review[]
     */
    public function findByMovie(Movie $movie);
    
    /**
     * @param User $user
     * @return bool|Review[]
     */
    public function findByUser(User $user);
    
}
