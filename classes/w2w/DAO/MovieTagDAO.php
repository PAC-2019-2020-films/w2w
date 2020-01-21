<?php

namespace w2w\DAO;

use w2w\Model\Movie;
use w2w\Model\Tag;

interface MovieTagDAO extends GenericDAO
{

    /**
     * @param Movie $movie
     * @return bool|Tag[]
     */
    public function selectMovieTagsByMovie(Movie $movie);

    /**
     * @param Tag $tag
     * @param Movie $movie
     * @return bool|int
     */
    public function deleteMovieTag(Tag $tag, Movie $movie);

}
