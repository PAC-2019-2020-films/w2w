<?php
namespace Test\w2w\DAO\Doctrine;

use \Test\BaseTestCase;
use \w2w\DAO\DAOFactory;
use \w2w\DAO\Doctrine\DoctrineReviewDAO;
use \w2w\Model\Review;

class DoctrineReviewDAOTest extends BaseTestCase
{
    
    protected function getMovieByTitle($title)
    {
        $daoFactory = DAOFactory::getDAOFactory();
        $dao = $daoFactory->getMovieDAO();
        $item = $dao->findByTitle($title);
        return $item;
    }
    protected function getUserByUserName($userName)
    {
        $daoFactory = DAOFactory::getDAOFactory();
        $dao = $daoFactory->getUserDAO();
        $item = $dao->findByUserName($userName);
        return $item;
    }

    public function testFindByMovie()
    {
        $title = "Bohemian Rhapsody";
        $movie = $this->getMovieByTitle($title);
        $dao = new DoctrineReviewDAO();
        $items = $dao->findByMovie($movie);
        $this->assertNonEmptyArrayOf(Review::class, $items);
        foreach ($items as $item) {
            $this->assertEquals($item->getMovie(), $movie);
        }
    }

    public function testFindByUser()
    {
        $userName = "Raoul";
        $user = $this->getUserByUserName($userName);
        $dao = new DoctrineReviewDAO();
        $items = $dao->findByUser($user);
        $this->assertNonEmptyArrayOf(Review::class, $items);
        foreach ($items as $item) {
            $this->assertEquals($item->getUser(), $user);
        }
    }

}
