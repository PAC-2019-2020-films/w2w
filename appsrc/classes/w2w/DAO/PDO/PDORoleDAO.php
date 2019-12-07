<?php

namespace w2w\DAO\PDO;

use w2w\DAO\RoleDAO;
use w2w\Model\Role;

class PDORoleDAO extends PDOGenericDAO implements RoleDAO
{
    private $table = "roles";
    
    /**
     * RoleDAO constructor.
     */
    public function __construct()
    {
        parent::__construct("roles", "\\w2w\\Model\\Role");
    }
    
    public function fetchFromRow($row)
    {
        return $this->roleObjectBinder($row);
    }
    


    
    /**
     * roleObjectBinder
     * Binds a PDO::fetchAll result row to a new Category Object
     * @param array $roleArray
     * @return bool|Role
     */
    public function roleObjectBinder(array $roleArray)
    {
        if (isset($roleArray['id']) && isset($roleArray['name'])) {
            $role = new Role(
                $roleArray['id'],
                $roleArray['name']
            );
            
            if (isset($roleArray['description'])) {
                $role->setDescription($roleArray['description']);
            }
            
            return $role;
        } else {
            return false;
        }
    }
    
    /**
     * @return bool|Role[]
     */
    public function selectAllRoles()
    {
        $roles = [];
        
        $sql = "SELECT  {$this->table}.id,
                    {$this->table}.name, 
                    {$this->table}.description
            FROM {$this->table}
            ORDER BY {$this->table}.name;
            ";
        
        $result = $this->select($sql);
        
        if (is_array($result)) {
            foreach ($result as $role) {
                array_push($roles, $this->roleObjectBinder($role));
            }
            return $roles;
        }
        
        /*
        * TODO : handle PDOException ?
        */
        
        return false;
    }
    
    /**
     * @param string $name
     * @return bool|Role
     */
    public function selectRoleByName(string $name)
    {
        $sql = "SELECT  {$this->table}.id,
                    {$this->table}.name, 
                    {$this->table}.description
            FROM {$this->table}
            WHERE {$this->table}.name = :name;
            ";
        $params = [':name' => [$name, self::PARAM_STR]];
        return $this->fetchOne($sql, $params);
        
        
        
        $result = $this->select($sql, $condition, $dataType);
        
        
        
        
        // plante si result vide (undefined offset)
        
        if (is_array($result)) {
            return $this->roleObjectBinder($result[0]);
        }
        
        /*
        * TODO : handle PDOException ?
        */
        
        return false;
    }
    
    
    /**
     * @Override
     */
    public function findByName($name)
    {
        return $this->selectRoleByname($name);
    }
    
    /**
     * @param int $id
     * @return bool|Role
     */
    public function selectRoleById(int $id)
    {
        $sql = "SELECT  {$this->table}.id,
                    {$this->table}.name, 
                    {$this->table}.description
            FROM {$this->table}
            WHERE {$this->table}.id = :id;
            ";
        
        $params = [':id' => [$id, self::PARAM_INT]];
        return $this->fetchOne($sql, $params);
        
        

        $result = $this->select($sql, $params);
        
        // plante si result vide (undefined offset) :
        
        if (is_array($result)) {
            return $this->roleObjectBinder($result[0]);
        }
        
        /*
        * TODO : handle PDOException ?
        */
        
        return false;
    }
    
    
    /**
     * @param Role $role
     * @return bool|int
     */
    public function insertRole(Role $role)
    {
        // id not auto incremented !
        $data = [
            'id'        => [$role->getId(), self::PARAM_INT],
            'name'        => $role->getName(),
            'description' => $role->getDescription()
        ];
        
        $result = $this->genericInsert($data);

        //$result = $this->insert($this->table, $data);
        if (is_int($result)) {
            return $result;
        }
        
        /*
        * TODO : handle PDOException ?
        */
        
        return false;
    }
    
    /**
     * @param Role $role
     * @return bool|int
     */
    public function updateRole(Role $role)
    {
        $data = [
            'name'        => [$role->getName(), 2],
            'description' => [$role->getDescription(), 2]
        ];
        
        $condition = "{$this->table}.id = :id";
        
        $result = $this->genericUpdate($this->table, $data, $condition, $role->getId());
        
        if (is_int($result)) {
            return $result;
        }
        
        /*
        * TODO : handle PDOException ?
        */
        return false;
    }
    
    /**
     * @param Role $role
     * @return bool|int
     */
    public function deleteRole(Role $role)
    {
        $condition = "{$this->table}.id = :id";
        
        $result = $this->genericDelete($this->table, $condition, $role->getId());
        
        if (is_int($result)) {
            return $result;
        }
        
        /*
        * TODO : handle PDOException ?
        */
        
        return false;
    }
    
}
