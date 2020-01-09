<?php
namespace Test\w2w\DAO\Doctrine;

use \Test\BaseTestCase;
use \w2w\DAO\DAOFactory;
use \w2w\DAO\Doctrine\DoctrineUserDAO;
use \w2w\Model\User;

class DoctrineUserDAOTest extends BaseTestCase
{
   
    public function testFindAll()
    {
        $dao = new DoctrineUserDAO();
        $items = $dao->findAll();
        $this->assertNonEmptyArrayOf(User::class, $items);
    }

    public function testFind()
    {
        $existingId = 3;
        $dao = new DoctrineUserDAO();
        $item = $dao->find($existingId);
        $this->assertNotNull($item);
        $this->assertInstanceOf(User::class, $item);
        $this->assertEquals($existingId, $item->getId());
    }

    public function testFindByEmail()
    {
        $existingEmail = "root@gmail.com";
        $dao = new DoctrineUserDAO();
        $item = $dao->findByEmail($existingEmail);
        $this->assertNotNull($item);
        $this->assertInstanceOf(User::class, $item);
        $this->assertEquals($existingEmail, $item->getEmail());
    }

    public function testFindByUserName()
    {
        $existingUserName = "root";
        $dao = new DoctrineUserDAO();
        $item = $dao->findByUserName($existingUserName);
        $this->assertNotNull($item);
        $this->assertInstanceOf(User::class, $item);
        $this->assertEquals($existingUserName, $item->getUserName());
    }

    public function testFindByRole()
    {
        $roleName = "user";
        $role = (DAOFactory::getDAOFactory())->getRoleDAO()->findByname($roleName);
        $dao = new DoctrineUserDAO();
        $items = $dao->findByRole($role);
        $this->assertNonEmptyArrayOf(User::class, $items);
        foreach ($items as $item) {
            $this->assertEquals($item->getRole(), $role);
        }
    }

}
