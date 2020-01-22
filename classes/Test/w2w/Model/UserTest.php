<?php
namespace Test\w2w\Model;

use \Test\BaseTestCase;
use \w2w\Model\User;
use \w2w\Model\Role;

class UserTest extends BaseTestCase
{
    
    public function testConstructorAndGetters()
    {
        $id = 666;
        $userName = "Roger";
        $email = "roger@gmail.com";
        $emailVerified = false;
        $passwordHash = password_hash("roger", PASSWORD_DEFAULT);
        $firstName = "Roger";
        $lastName = "Laboureur";
        $createdAt = new \DateTime();
        $updatedAt = new \DateTime();
        $lastLoginAt = new \DateTime();
        $banned = false;
        $numberReviews = 0;
        $role = new Role(666, "erf", "erf");
        $item = new User($id, $userName, $email, $emailVerified, $passwordHash, $firstName, $lastName, $createdAt, $updatedAt, $lastLoginAt, $banned, $numberReviews, $role);
        $this->assertInstanceOf(User::class, $item);
        $this->assertEquals($item->getId(), $id);
        $this->assertEquals($item->getUserName(), $userName);
        $this->assertEquals($item->getEmail(), $email);
        $this->assertEquals($item->isEmailVerified(), $emailVerified);
        $this->assertEquals($item->getPasswordHash(), $passwordHash);
        $this->assertEquals($item->getFirstName(), $firstName);
        $this->assertEquals($item->getLastName(), $lastName);
        $this->assertEquals($item->getCreatedAt(), $createdAt);
        $this->assertEquals($item->getUpdatedAt(), $updatedAt);
        $this->assertEquals($item->getLastLoginAt(), $lastLoginAt);
        $this->assertEquals($item->isBanned(), $banned);
        $this->assertEquals($item->getNumberReviews(), $numberReviews);
        $this->assertEquals($item->getRole(), $role);
    }
    
    public function testEmptyConstructor()
    {
        $item = new User();
        $this->assertInstanceOf(User::class, $item);
    }

    public function testToString()
    {
        $id = 666;
        $userName = "Roger";
        $email = "roger@gmail.com";
        $emailVerified = false;
        $passwordHash = password_hash("roger", PASSWORD_DEFAULT);
        $firstName = "Roger";
        $lastName = "Laboureur";
        $createdAt = new \DateTime();
        $updatedAt = null;
        $lastLoginAt = new \DateTime("1998-07-12 21:27:33"); # goaaaaaaaaaaaaaaaaaaaaal
        $banned = false;
        $numberReviews = 0;
        $role = new Role(666, "erf", "erf");
        $item = new User($id, $userName, $email, $emailVerified, $passwordHash, $firstName, $lastName, $createdAt, $updatedAt, $lastLoginAt, $banned, $numberReviews, $role);
        $toString = (string) $item;
        $this->assertNotNull($toString);
        $this->assertIsString($toString);
        $this->assertGreaterThan(0, strlen($toString));
        $this->assertStringStartsWith("User#{$id}", $toString);
        $this->assertEquals(
            sprintf(
                User::TOSTRING_FORMAT, 
                $id, $userName, $email, $emailVerified, $passwordHash, $firstName, $lastName, 
                $createdAt ? $createdAt->format(User::DEFAULT_DATETIME_FORMAT) : null, 
                $updatedAt ? $updatedAt->format(User::DEFAULT_DATETIME_FORMAT) : null, 
                $lastLoginAt ? $lastLoginAt->format(User::DEFAULT_DATETIME_FORMAT) : null,
                $banned, 
                $numberReviews,
                $role
            ),
            $toString
        );
    }
    
}
