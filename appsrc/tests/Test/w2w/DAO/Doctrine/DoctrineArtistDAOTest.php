<?php
namespace Test\w2w\DAO\Doctrine;

use \Test\BaseTestCase;
use \w2w\DAO\Doctrine\DoctrineArtistDAO;
use \w2w\Model\Artist;

class DoctrineArtistDAOTest extends BaseTestCase
{

    public function testFindAll()
    {
        $dao = new DoctrineArtistDAO();
        $items = $dao->findAll();
        $this->assertNonEmptyArrayOf(Artist::class, $items);
    }

    public function testFind()
    {
        $existingId = 3;
        $dao = new DoctrineArtistDAO();
        $item = $dao->find($existingId);
        $this->assertInstanceOf(Artist::class, $item);
        $this->assertEquals($existingId, $item->getId());
    }

    public function testFindNonExisting()
    {
        $nonExistingId = 3789145;
        $dao = new DoctrineArtistDAO();
        $item = $dao->find($nonExistingId);
        $this->assertNull($item);
    }

    public function testFindByFirstNameAndLastName()
    {
        $firstName = "Jean-Pierre";
        $lastName = "Dardenne";
        $dao = new DoctrineArtistDAO();
        $item = $dao->findByFirstNameAndLastName($firstName, $lastName);
        $this->assertInstanceOf(Artist::class, $item);
        $this->assertEquals($firstName, $item->getFirstName());
        $this->assertEquals($lastName, $item->getLastName());
    }

    public function testFindByFirstNameAndLastNameNonExisting()
    {
        $firstName = "Jean-Pierre";
        $lastName = "Vandamme de kdlmqskdl mqsdlmkùmqs";
        $dao = new DoctrineArtistDAO();
        $item = $dao->findByFirstNameAndLastName($firstName, $lastName);
        $this->assertNull($item);
    }

}
