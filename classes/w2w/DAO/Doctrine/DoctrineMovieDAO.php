<?php

namespace w2w\DAO\Doctrine;

use Doctrine\ORM\Tools\Pagination\Paginator;
use w2w\DAO\MovieDAO;
use w2w\Model\Artist;
use w2w\Model\Category;
use w2w\Model\Movie;
use w2w\Model\Rating;
use w2w\Model\Review;
use w2w\Model\Tag;
use DateTime;
use w2w\Utils\Utils;

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
        $dql = sprintf("SELECT m FROM %s m JOIN m.category c WHERE c.id=:id ORDER BY m.title ASC", Movie::class);
        $query = $this->getEntityManager()->createQuery($dql);
        //echo $query->getSQL() . "\n";        
        $query->setParameter('id', $category->getId());
        return $query->getResult();
    }

    /**
     * @param Tag $tag
     * @return bool|Movie[]
     */
    public function findByTag(Tag $tag)
    {
        $dql = sprintf("SELECT m FROM %s m JOIN m.tags t WHERE t.id=:id ORDER BY m.title ASC", Movie::class);
        $query = $this->getEntityManager()->createQuery($dql);
        //echo $query->getSQL() . "\n";        
        $query->setParameter('id', $tag->getId());
        return $query->getResult();
    }

    /**
     * @param Rating $rating
     * @return bool|array
     */
    public function findByRating(Rating $rating)
    {
        $dql = sprintf("SELECT m FROM %s m JOIN m.rating r WHERE r.id=:id", Movie::class);
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter("id", $rating->getId());
        return $query->getResult();
    }

    /**
     * @param string $keyword
     * @return bool|array
     *
     * @todo rename as findByKeyword ?
     */
    public function findBySearch(string $keyword)
    {
        $dql = sprintf("SELECT m FROM %s m WHERE m.title LIKE :keyword OR m.description LIKE :keyword ORDER BY m.title ASC", Movie::class);
        $query = $this->getEntityManager()->createQuery($dql);
        //echo $query->getSQL() . "\n";        
        $query->setParameter('keyword', "%" . $keyword . "%");
        return $query->getResult();
    }

    /**
     * @return bool|array
     *
     * @todo add a datetime of creation of the record in the movies table ? (for now, sorting on the id...)
     * @todo rename as more generalized, without the "five" restriction
     */
    public function findLast($number = 5)
    {
        $dql = sprintf("SELECT m FROM %s m ORDER BY m.id DESC", Movie::class);
        $query = $this->getEntityManager()->createQuery($dql)->setMaxResults($number);
        return $query->getResult();
    }

    /**
     * @return bool|Movie[]
     *
     * @todo rename as more generalized, without the "five" restriction
     */
    public function findBest($number = 10)
    {
        $dql = sprintf("SELECT m FROM %s m LEFT JOIN m.rating r ORDER BY r.value DESC, m.id DESC", Movie::class);
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setMaxResults($number);
        return $query->getResult();
    }

    /**
     * @param Artist $director
     * @return bool|Movie[]
     */
    public function findByDirector(Artist $director)
    {
        $dql = sprintf("SELECT m FROM %s m JOIN m.directors ar WHERE ar.id = :id", Movie::class);
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter("id", $director->getId());
        return $query->getResult();
    }

    /**
     * @param Artist $actor
     * @return bool|Movie[]
     */
    public function findByActor(Artist $actor)
    {
        $dql = sprintf("SELECT m FROM %s m JOIN m.actors ar WHERE ar.id = :id", Movie::class);
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter("id", $actor->getId());
        return $query->getResult();
    }

    /**
     * @param DateTime $date
     * @return bool|array
     */
    public function findByYear(int $year)
    {
        $dql = sprintf("SELECT m FROM %s m WHERE m.year = :year", Movie::class);
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter("year", $year);
        return $query->getResult();
    }

    public function getAllMovies($currentPage = 1, $limit = 5)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()->select('m')->from(Movie::class, 'm')->orderBy('m.title', 'ASC');
        $query = $qb->getQuery();

        $paginator = Utils::paginate($query, $currentPage, $limit);

        return $paginator;
    }

}
