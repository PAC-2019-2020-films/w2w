<?php
namespace Test\w2w\DAO\PDO;

use \Test\BaseTestCase;
use \w2w\DAO\PDO\UserDAO;
use \w2w\Model\User;

class UserDAOTest extends BaseTestCase
{
   
    public function testSelectAllUsers()
    {
        $dao = new UserDAO();
        $items = $dao->selectAllUsers();
        $this->assertNonEmptyArrayOf("\\w2w\\Model\\User", $items);
    }

    public function testSelectUserById()
    {
        $existingId = 3;
        $dao = new UserDAO();
        $item = $dao->selectUserById($existingId);
        $this->assertNotNull($item);
        $this->assertInstanceOf(User::class, $item);
        $this->assertEquals($existingId, $item->getId());
    }

    public function testSelectUserByEmail()
    {
        $existingEmail = "root@gmail.com";
        $dao = new UserDAO();
        $item = $dao->selectUserByEmail($existingEmail);
        $this->assertNotNull($item);
        $this->assertInstanceOf(User::class, $item);
        $this->assertEquals($existingEmail, $item->getEmail());
    }

}
