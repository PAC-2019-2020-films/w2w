<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\MovieActorDAO;
use w2w\Model\Artist;
use w2w\Model\Movie;

class DoctrineMovieActorDAO extends DoctrineGenericDAO implements MovieActorDAO
{
    
    public function __construct()
    {
        parent::__construct("\\w2w\\Model\\MovieActor");
    }

    /**
     * @param Artist $artist
     * @return bool
     */
    public function isMovieActorrByArtist(Artist $artist)
    {
    }
    
    /**
     * @param Movie $movie
     * @return bool|Artist[]
     */
    public function findByMovie(Movie $movie)
    {
    }
    
    /**
     * @param Artist $actor
     * @param Movie $movie
     * @return bool|int
     */
    public function deleteMovieActorByMovie(Artist $actor, Movie $movie)
    {
    }

    /**
     * @param Artist $actor
     * @return bool|int
     */
    public function deleteMovieActor(Artist $actor)
    {
    }
    
}
