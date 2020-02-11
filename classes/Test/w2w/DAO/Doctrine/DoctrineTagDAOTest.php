<?php
namespace Test\w2w\DAO\Doctrine;

use \Test\BaseTestCase;
use \w2w\DAO\Doctrine\DoctrineTagDAO;
use \w2w\Model\Tag;

class DoctrineTagDAOTest extends BaseTestCase
{

    public function testFindAll()
    {
        $dao = new DoctrineTagDAO();
        $items = $dao->findAll();
        $this->assertNonEmptyArrayOf(Tag::class, $items);
    }

    public function testFind()
    {
        $existingId = 1;
        $dao = new DoctrineTagDAO();
        $item = $dao->find($existingId);
        $this->assertInstanceOf(Tag::class, $item);
        $this->assertEquals($item->getId(), $existingId);
    }

    public function testFindWithNonExistingId()
    {
        $nonExistingId = 111785;
        $dao = new DoctrineTagDAO();
        $item = $dao->find($nonExistingId);
        $this->assertNull($item);
    }

    public function testFindByName()
    {
        $existingName = "Drama";
        $dao = new DoctrineTagDAO();
        $item = $dao->findByName($existingName);
        $this->assertInstanceOf(Tag::class, $item);
        $this->assertEquals($item->getName(), $existingName);
    }

    public function testFindByNameNonExisting()
    {
        $nonExistingName = "dkqsdjl";
        $dao = new DoctrineTagDAO();
        $item = $dao->findByName($nonExistingName);
        $this->assertNull($item);
    }

}
