<?php
namespace Test\w2w\DAO\PDO;

use \Test\BaseTestCase;
use \w2w\DAO\PDO\RoleDAO;
use \w2w\Model\Role;

class RoleDAOTest extends BaseTestCase
{

    public function testSelectAllRolesd()
    {
        $dao = new RoleDAO();
        $items = $dao->selectAllRoles();
        $this->assertNonEmptyArrayOf(Role::class, $items);
    }

    public function testSelectRoleById()
    {
        $existingId = 1;
        $dao = new RoleDAO();
        $item = $dao->selectRoleById($existingId);
        $this->assertInstanceOf(Role::class, $item);
        $this->assertEquals($item->getId(), $existingId);
    }

    public function testSelectRoleByIdNonExisting()
    {
        $nonExistingId = 111;
        $dao = new RoleDAO();
        $item = $dao->selectRoleById($nonExistingId);
        $this->assertNull($item);
    }

    public function testSelectRoleByName()
    {
        $existingName = "admin";
        $dao = new RoleDAO();
        $item = $dao->selectRoleByName($existingName);
        $this->assertInstanceOf(Role::class, $item);
    }

    public function testSelectRoleByNameNonExisting()
    {
        $nonExistingName = "dkqsdjl";
        $dao = new RoleDAO();
        $item = $dao->selectRoleByName($nonExistingName);
        $this->assertNull($item);
    }




    public function testInsertRole()
    {
        $id = time(); // must be unique and is not auto-incremented, but time() is dangerous
        $role = new Role($id, "temporaire - $id", "pour test");
        $dao = new RoleDAO();
        $affectedRows = $dao->insertRole($role);
        $this->assertEquals(1, $affectedRows);
        
        $item = $dao->selectRoleByid($id);
        $this->assertInstanceOf(Role::class, $item);
        $this->assertEquals($item->getId(), $role->getId());
        $this->assertEquals($item->getName(), $role->getName());
        $this->assertEquals($item->getDescription(), $role->getDescription());
    }

    public function testUpdateRole()
    {
        // récupère enregistremenrt existant :
        $existingId = 3;
        $dao = new RoleDAO();
        $role = $dao->selectRoleById($existingId);
        // le modifie un peu :
        $role->setDescription("modified at " . date("Y-m-d H:i:s"));
        // le met à jour :
        $affectedRows = $dao->updateRole($role);
        $this->assertEquals(1, $affectedRows);
        // le récupère à nouveau sur base de son id et vérifie l'égalité des champs :
        $item = $dao->selectRoleByid($existingId);
        $this->assertInstanceOf(Role::class, $item);
        $this->assertEquals($item->getId(), $role->getId());
        $this->assertEquals($item->getName(), $role->getName());
        $this->assertEquals($item->getDescription(), $role->getDescription());
    }

    public function testDeleteRole()
    {
        // insertion enregistrement temporaire :
        $temporaryNonExisting = 667;
        $role = new Role($temporaryNonExisting, "temporary #$temporaryNonExisting", "tempo... pour test");
        $dao = new RoleDAO();
        $affectedRows = $dao->insertRole($role);
        $this->assertEquals(1, $affectedRows);
        // on le récupère :
        $item = $dao->selectRoleById($temporaryNonExisting);
        $this->assertInstanceOf(Role::class, $item);
        // on l'efface : 
        $affectedRows = $dao->deleteRole($item);
        $this->assertEquals(1, $affectedRows);
        // on essaye de le récupérer encore, doit être null :
        $item = $dao->selectRoleById($temporaryNonExisting);
        $this->assertNull($item);
    }

}
