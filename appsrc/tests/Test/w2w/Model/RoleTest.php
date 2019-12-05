<?php
namespace Test\w2w\Model;

use \Test\BaseTestCase;
use \w2w\Model\Role;

class RoleTest extends BaseTestCase
{
    
    public function testConstructorAndGetters()
    {
        $id = 666;
        $name = "Déchets";
        $description = "Utilisateurs de merde";
        $item = new Role($id, $name, $description);
        $this->assertInstanceOf(Role::class, $item);
        $this->assertEquals($item->getId(), $id);
        $this->assertEquals($item->getName(), $name);
        $this->assertEquals($item->getDescription(), $description);
    }
    
    public function testEmptyConstructor()
    {
        $item = new Role();
        $this->assertInstanceOf(Role::class, $item);
    }

    public function testToString()
    {
        $id = 666;
        $name = "Déchets";
        $description = "Utilisateurs de merde";
        $item = new Role($id, $name, $description);
        $toString = (string) $item;
        $this->assertNotNull($toString);
        $this->assertIsString($toString);
        $this->assertGreaterThan(0, strlen($toString));
        $this->assertStringStartsWith("Role#{$id}", $toString);
        $this->assertEquals(
            sprintf(Role::TOSTRING_FORMAT, $id, $name, $description),
            $toString
        );
    }
    
}
