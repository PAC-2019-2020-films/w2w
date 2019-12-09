<?php
namespace Test\w2w\DAO\Doctrine;

use \Test\BaseTestCase;
use \w2w\DAO\Doctrine\DoctrineRoleDAO;
use \w2w\Model\Role;

class PDORoleDAOTest extends BaseTestCase
{

    public function testFindAll()
    {
        $dao = new DoctrineRoleDAO();
        $items = $dao->findAll();
        $this->assertNonEmptyArrayOf(Role::class, $items);
    }

    public function testFind()
    {
        $existingId = 1;
        $dao = new DoctrineRoleDAO();
        $item = $dao->find($existingId);
        $this->assertInstanceOf(Role::class, $item);
        $this->assertEquals($item->getId(), $existingId);
    }

    public function testFindWithNonExistingId()
    {
        $nonExistingId = 111;
        $dao = new DoctrineRoleDAO();
        $item = $dao->find($nonExistingId);
        $this->assertNull($item);
    }

    public function testFindByName()
    {
        $existingName = "admin";
        $dao = new DoctrineRoleDAO();
        $item = $dao->findByName($existingName);
        $this->assertInstanceOf(Role::class, $item);
    }

    public function testFindByNameNonExisting()
    {
        $nonExistingName = "dkqsdjl";
        $dao = new DoctrineRoleDAO();
        $item = $dao->findByName($nonExistingName);
        $this->assertNull($item);
    }

    public function testSave()
    {
        $dao = new DoctrineRoleDAO();
        $id = $dao->max("id") + 1;
        $role = new Role($id, "temporaire - $id", "pour test");
        $affectedRows = $dao->save($role);
    #$this->assertEquals(1, $affectedRows);
        
        $item = $dao->find($id);
        $this->assertInstanceOf(Role::class, $item);
        $this->assertEquals($item->getId(), $role->getId());
        $this->assertEquals($item->getName(), $role->getName());
        $this->assertEquals($item->getDescription(), $role->getDescription());
    }

    public function testUpdate()
    {
        // récupère enregistremenrt existant :
        $existingId = 3;
        $dao = new DoctrineRoleDAO();
        $role = $dao->find($existingId);
        // le modifie un peu :
        $role->setDescription("modified at " . date("Y-m-d H:i:s"));
        // le met à jour :
        $affectedRows = $dao->update($role);
    #$this->assertEquals(1, $affectedRows);
        // le récupère à nouveau sur base de son id et vérifie l'égalité des champs :
        $item = $dao->find($existingId);
        $this->assertInstanceOf(Role::class, $item);
        $this->assertEquals($item->getId(), $role->getId());
        $this->assertEquals($item->getName(), $role->getName());
        $this->assertEquals($item->getDescription(), $role->getDescription());
    }

    public function testDelete()
    {
        // insertion enregistrement temporaire :
        $temporaryNonExisting = 667;
        $role = new Role($temporaryNonExisting, "temporary #$temporaryNonExisting", "tempo... pour test");
        $dao = new DoctrineRoleDAO();
        $affectedRows = $dao->save($role);
    #$this->assertEquals(1, $affectedRows);
        // on le récupère :
        $item = $dao->find($temporaryNonExisting);
        $this->assertInstanceOf(Role::class, $item);
        // on l'efface : 
        $affectedRows = $dao->delete($item);
    #$this->assertEquals(1, $affectedRows);
        // on essaye de le récupérer encore, doit être null :
        $item = $dao->find($temporaryNonExisting);
        $this->assertNull($item);
    }
    
    public function testExtremaIds()
    {
        $dao = new DoctrineRoleDAO();
        $max = $dao->max("id");
        $min = $dao->min("id");
        $this->assertTrue(is_numeric($max));
        $this->assertTrue($max > 0);
        $this->assertTrue(is_numeric($min));
        $this->assertTrue($min > 0);
        $this->assertTrue($min <= $max);
    }

}
