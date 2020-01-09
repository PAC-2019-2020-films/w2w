<?php

namespace w2w\DAO;

use w2w\Model\Artist;
use w2w\Model\Movie;

interface MovieActorDAO extends GenericDAO
{
    
    /**
     * @param Artist $artist
     * @return bool
     */
    public function isMovieActorrByArtist(Artist $artist);
    
    /**
     * @param Movie $movie
     * @return bool|Artist[]
     */
    public function findByMovie(Movie $movie);
    
    /**
     * @param Artist $actor
     * @param Movie $movie
     * @return bool|int
     */
    public function deleteMovieActorByMovie(Artist $actor, Movie $movie);

    /**
     * @param Artist $actor
     * @return bool|int
     */
    public function deleteMovieActor(Artist $actor);
    
}
