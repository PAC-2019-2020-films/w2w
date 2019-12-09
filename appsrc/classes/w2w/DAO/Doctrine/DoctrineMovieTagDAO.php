<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\MovieTagDAO;
use w2w\Model\Movie;
use w2w\Model\Tag;

class DoctrineMovieTagDAO extends DoctrineGenericDAO implements MovieTagDAO
{

    public function __construct()
    {
        parent::__construct("\\w2w\\Model\\MovieTag");
    }

    /**
     * @param Movie $movie
     * @return bool|Tag[]
     */
    public function selectMovieTagsByMovie(Movie $movie)
    {
    }

    /**
     * @param Tag $tag
     * @param Movie $movie
     * @return bool|int
     */
    public function deleteMovieTag(Tag $tag, Movie $movie)
    {
    }

}
