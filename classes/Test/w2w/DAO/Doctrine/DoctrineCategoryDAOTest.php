<?php
namespace Test\w2w\DAO\Doctrine;

use \Test\BaseTestCase;
use \w2w\DAO\Doctrine\DoctrineCategoryDAO;
use \w2w\Model\Category;

class DoctrineCategoryDAOTest extends BaseTestCase
{

    public function testFindAll()
    {
        $dao = new DoctrineCategoryDAO();
        $items = $dao->findAll();
        $this->assertNonEmptyArrayOf(Category::class, $items);
    }

    public function testFind()
    {
        $existingId = 1;
        $dao = new DoctrineCategoryDAO();
        $item = $dao->find($existingId);
        $this->assertInstanceOf(Category::class, $item);
        $this->assertEquals($item->getId(), $existingId);
    }

    public function testFindWithNonExistingId()
    {
        $nonExistingId = 111785;
        $dao = new DoctrineCategoryDAO();
        $item = $dao->find($nonExistingId);
        $this->assertNull($item);
    }

    public function testFindByName()
    {
        $existingName = "En couple";
        $dao = new DoctrineCategoryDAO();
        $item = $dao->findByName($existingName);
        $this->assertInstanceOf(Category::class, $item);
        $this->assertEquals($item->getName(), $existingName);
    }

    public function testFindByNameNonExisting()
    {
        $nonExistingName = "dkqsdjl";
        $dao = new DoctrineCategoryDAO();
        $item = $dao->findByName($nonExistingName);
        $this->assertNull($item);
    }

}
