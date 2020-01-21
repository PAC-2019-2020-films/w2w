<?php

namespace w2w\DAO;

use w2w\Model\Artist;
use w2w\Model\Movie;

interface MovieDirectorDAO extends GenericDAO
{

    /**
     * @param Artist $artist
     * @return bool
     */
    public function isMovieDirectorByArtist(Artist $artist);

    /**
     * @param Movie $movie
     * @return bool|Artist[]
     */
    public function findByMovie(Movie $movie);

    /**
     * @param Artist $director
     * @param Movie $movie
     * @return bool|int
     */
    public function deleteMovieDirectorByMovie(Artist $director, Movie $movie);

    /**
     * @param Artist $director
     * @return bool|int
     */
    public function deleteMovieDirector(Artist $director);

}
