<?php
namespace Test\w2w\DAO\Doctrine;

use \Test\BaseTestCase;
use \w2w\DAO\DAOFactory;
use \w2w\DAO\Doctrine\DoctrineMovieDAO;
use \w2w\Model\Movie;

class DoctrineMovieDAOTest extends BaseTestCase
{
    

    public function testFindByTitle()
    {
        $existingTitle = "Bohemian Rhapsody";
        $dao = new DoctrineMovieDAO();
        $item = $dao->findByTitle($existingTitle);
        $this->assertInstanceOf(Movie::class, $item);
    }

    public function testFindByTitleNonExisting()
    {
        $existingTitle = "Bohemian Rhapsoqsdqsdkldy";
        $dao = new DoctrineMovieDAO();
        $item = $dao->findByTitle($existingTitle);
        $this->assertNull($item);
    }

    public function testFindByCategory()
    {
        $name = "Divers";
        $category = (DAOFactory::getDAOFactory()->getCategoryDAO())->findByName($name);
        $dao = new DoctrineMovieDAO();
        $items = $dao->findByCategory($category);
        $this->assertNonEmptyArrayOf(Movie::class, $items);
        foreach ($items as $item) {
            $this->assertEquals($item->getCategory(), $category);
        }
    }

    public function testFindByTag()
    {
        $name = "drama";
        $tag = (DAOFactory::getDAOFactory()->getTagDAO())->findByName($name);
        $dao = new DoctrineMovieDAO();
        $items = $dao->findByTag($tag);
        $this->assertNonEmptyArrayOf(Movie::class, $items);
        foreach ($items as $item) {
            $this->assertTrue($item->hasTag($tag));
        }
    }

    public function testFindByRating()
    {
        $value = "-1";
        $rating = (DAOFactory::getDAOFactory()->getRatingDAO())->findByValue($value);
        $dao = new DoctrineMovieDAO();
        $items = $dao->findByRating($rating);
        $this->assertNonEmptyArrayOf(Movie::class, $items);
        foreach ($items as $item) {
            $this->assertEquals($item->getRating(), $rating);
        }
    }

    public function testFindBySearch()
    {
        $keyword = "silence";
        $dao = new DoctrineMovieDAO();
        $items = $dao->findBySearch($keyword);
        $this->assertNonEmptyArrayOf(Movie::class, $items);
    }

    public function testFindBySearchNoResult()
    {
        $keyword = "silencdjkhqskdj hkjqse";
        $dao = new DoctrineMovieDAO();
        $items = $dao->findBySearch($keyword);
        $this->assertIsArray($items);
        $this->assertEquals(0, count($items));
    }

    public function testFindLast()
    {
        $number = 2;
        $dao = new DoctrineMovieDAO();
        $items = $dao->findLast($number);
        $this->assertNonEmptyArrayOf(Movie::class, $items);
        $this->assertEquals($number, count($items));
    }

    public function testFindBest()
    {
        $number = 3;
        $dao = new DoctrineMovieDAO();
        $items = $dao->findBest($number);
        $this->assertNonEmptyArrayOf(Movie::class, $items);
        $this->assertEquals($number, count($items));
    }

    public function testFindByDirector()
    {
        $firstName = "Clint";
        $lastName = "Eastwood";
        $director = (DAOFactory::getDAOFactory())->getArtistDAO()->findByFirstNameAndLastName($firstName, $lastName);
        $dao = new DoctrineMovieDAO();
        $items = $dao->findByDirector($director);
        $this->assertNonEmptyArrayOf(Movie::class, $items);
        foreach ($items as $item) {
            $this->assertTrue($item->hasDirector($director));
        }
    }

    public function testFindByActor()
    {
        $firstName = "Clint";
        $lastName = "Eastwood";
        $actor = (DAOFactory::getDAOFactory())->getArtistDAO()->findByFirstNameAndLastName($firstName, $lastName);
        $dao = new DoctrineMovieDAO();
        $items = $dao->findByActor($actor);
        $this->assertNonEmptyArrayOf(Movie::class, $items);
        foreach ($items as $item) {
            $this->assertTrue($item->hasActor($actor));
        }
    }

    public function testFindByYear()
    {
        $year = 2005;
        $dao = new DoctrineMovieDAO();
        $items = $dao->findByYear($year);
        $this->assertNonEmptyArrayOf(Movie::class, $items);
        foreach ($items as $item) {
            $this->assertEquals($item->getYear(), $year);
        }
    }


}
