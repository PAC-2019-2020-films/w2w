<?php
namespace Test\w2w\DAO;

use \Test\BaseTestCase;
use \w2w\DAO\UserDAO;
use \w2w\Model\User;

class UserDAOTest extends BaseTestCase
{

    
    public function testSelectUserById()
    {
        $existingUserId = 36;
        $dao = new UserDAO();
        $user = $dao->selectUserById($existingUserId);
        $this->assertNotNull($user);
        $this->assertInstanceOf(User::class, $user);
    }

}
