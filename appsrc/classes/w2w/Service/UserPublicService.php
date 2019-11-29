<?php
    
    
    namespace w2w\Service;
    
    use w2w\DAO\UserDAO;
    use \w2w\Model\User;
    
    class UserPublicService extends PublicService
    {
        
        private $roleService;
        private $userDAO;
        
        /**
         * UserPublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->roleService = new RolePublicService();
            $this->userDAO = new UserDAO();
        }
        
        
        /**
         * @param int $id
         * @return User
         */
        public function getUserById(int $id)
        {
            return $this->userDAO->selectUserById($id);
        }
        
        /**
        * getUserByMail
        * @param string $mail
        * @return User
        */
        public function getUserByMail(string $mail)
        {
            return $this->userDAO->selectUserByMail($mail);
        }
        
        /**
        * getUserByUserName
        * @param string $userName
        * @return User
        */
        public function getUserByUserName(string $userName)
        {
            return $this->userDAO->selectUserByUserName($userName);
        }
        
        
        
    }