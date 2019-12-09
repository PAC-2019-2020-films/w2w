<?php

namespace w2w\DAO\Doctrine;

use w2w\DAO\MovieDAO;
use w2w\Model\Artist;
use w2w\Model\Category;
use w2w\Model\Movie;
use w2w\Model\Rating;
use w2w\Model\Tag;
use DateTime;

class DoctrineMovieDAO extends DoctrineGenericDAO implements MovieDAO
{
    
    public function __construct()
    {
        parent::__construct(Movie::class);
    }

    public function findByTitle(string $title)
    {
        return $this->findOneBy("title", $title);
    }

    /**
     * @param Category $category
     * @return bool|Movie[]
     */
    public function findByCategory(Category $category)
    {
    }
    
    /**
     * @param Tag $tag
     * @return bool|Movie[]
     */
    public function findByTag(Tag $tag)
    {
    }
    
    /**
     * @param Rating $rating
     * @return bool|array
     */
    public function findByRating(Rating $rating)
    {
    }
    
    /**
     * @param string $keyword
     * @return bool|array
     */
    public function findBySearch(string $keyword)
    {
    }
    
    /**
     * @return bool|array
     */
    public function findLastFive()
    {
    }
    
    /**
     * @return bool|Movie[]
     */
    public function findBestFive()
    {
    }
    
    /**
     * @param Artist $director
     * @return bool|Movie[]
     */
    public function findByDirector(Artist $director)
    {
    }
    
    /**
     * @param Artist $actor
     * @return bool|Movie[]
     */
    public function findByActor(Artist $actor)
    {
    }
    
    /**
     * @param DateTime $date
     * @return bool|array
     */
    public function findByYear(DateTime $date)
    {
    }
    
}
