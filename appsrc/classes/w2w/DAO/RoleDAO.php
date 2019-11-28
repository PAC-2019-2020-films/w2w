<?php
    
    
    namespace w2w\DAO;
    
    
    use w2w\Model\Role;
    
    class RoleDAO extends BaseDAO
    {
        private $table = "roles";
        
        /**
         * RoleDAO constructor.
         */
        public function __construct()
        {
            parent::__construct();
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
            
            
            $condition = [':name' => $name];
            $dataType  = 2;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                return $this->roleObjectBinder($result[0]);
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
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
            
            
            $condition = [':id' => $id];
            $dataType  = 1;
            
            $result = $this->select($sql, $condition, $dataType);
            
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
            $data = [
                'name'        => [$role->getName(), 2],
                'description' => [$role->getDescription(), 2]
            ];
            
            $result = $this->insert($this->table, $data);
            
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
            
            $result = $this->update($this->table, $data, $condition, $role->getId());
            
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
            
            $result = $this->delete($this->table, $condition, $role->getId());
            
            if (is_int($result)) {
                return $result;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
    }