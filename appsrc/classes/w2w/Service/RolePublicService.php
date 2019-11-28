<?php
    
    
    namespace w2w\Service;
    
    
    use w2w\DAO\RoleDAO;
    use \w2w\Model\Role;
    
    class RolePublicService extends PublicService
    {
        private $roleDAO;
        
        /**
         * RolePublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->roleDAO = new RoleDAO();
        }
        
       
        /**
         * getAllRoles
         * @return Role[]
         */
        public function getAllRoles()
        {
            return $this->roleDAO->selectAllRoles();
        }
        
        /**
        * getRoleByName
        * @param string $name
        * @return Role
        */
        public function getRoleByName(string $name)
        {
            return $this->roleDAO->selectRoleByName($name);
        }
        
        /**
         * @param int $id
         * @return Role
         */
        public function getRoleById(int $id)
        {
            return $this->roleDAO->selectRoleById($id);
        }
        
    }