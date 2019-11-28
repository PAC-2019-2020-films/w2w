<?php
    
    
    namespace w2w\DAO;
    
    
    use w2w\Model\Role;
    use w2w\Model\User;
    use w2w\Model\AuthenticationToken;
    
    class UserDAO extends BaseDAO
    {
        private $table = 'users';
        private $tableRole = 'roles';
        private $tableToken = 'authentication_tokens';
        
        private $roleDAO;
        
        /**
         * UserDAO constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->roleDAO = new RoleDAO();
        }
        
        /**
         * userObjectBinder
         * Binds a PDO::fetchAll result row to a new Category Object
         * @param array $userArray
         * @return bool|User
         */
        public function userObjectBinder(array $userArray)
        {
            if (isset($userArray['id']) && isset($userArray['user_name']) && isset($userArray['email']) && isset($userArray['email_verified']) && isset($userArray['password_hash']) && isset($userArray['created_at']) && isset($userArray['fk_role_id']) && isset($userArray['banned']) && isset($userArray['number_reviews'])) {
                $user = new User(
                    $userArray['id'],
                    $userArray['user_name'],
                    $userArray['email'],
                    $userArray['email_verified'],
                    $userArray['password_hash'],
                    $userArray['created_at'],
                    $this->roleDAO->selectRoleById($userArray['fk_role_id']),
                    $userArray['banned'],
                    $userArray['number_reviews']
                );
                
                if (isset($userArray['updated_at'])) {
                    $user->setUpdatedAt($userArray['updated_at']);
                }
                
                if (isset($userArray['last_login_at'])) {
                    $user->setLastLoginAt($userArray['last_login_at']);
                }
                
                return $user;
                
            } else {
                return false;
            }
        }
        
        
        /**
         * @return bool|User[]
         */
        public function selectAllUsers(): array
        {
            $users = [];
            
            $sql = "
            SELECT  {$this->table}.id, 
                    {$this->table}.user_name, 
                    {$this->table}.email, 
                    {$this->table}.email_verified, 
                    {$this->table}.password_hash, 
                    {$this->table}.first_name, 
                    {$this->table}.last_name, 
                    {$this->table}.created_at,
                    {$this->table}.updated_at,
                    {$this->table}.last_login_at,
                    {$this->table}.banned,
                    {$this->table}.number_reviews,
                    {$this->table}.fk_role_id,
                    {$this->tableRole}.id,
                    {$this->tableRole}.name,
                    {$this->tableRole}.description
            FROM {$this->table}
            LEFT JOIN {$this->tableRole} ON {$this->tableRole}.id = {$this->table}.fk_role_id
            ORDER BY {$this->table}.id;
        ";
            
            $result = $this->select($sql);
            
            if (is_array($result)) {
                foreach ($result as $user) {
                    array_push($users, $this->userObjectBinder($user));
                }
                return $users;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param int $id
         * @return bool|User
         */
        public function selectUserById(int $id)
        {
            $sql = "
            SELECT  {$this->table}.id, 
                    {$this->table}.user_name, 
                    {$this->table}.email, 
                    {$this->table}.email_verified, 
                    {$this->table}.password_hash, 
                    {$this->table}.first_name, 
                    {$this->table}.last_name, 
                    {$this->table}.created_at,
                    {$this->table}.updated_at,
                    {$this->table}.last_login_at,
                    {$this->table}.banned,
                    {$this->table}.number_reviews,
                    {$this->table}.fk_role_id,
                    {$this->tableRole}.id,
                    {$this->tableRole}.name,
                    {$this->tableRole}.description
            FROM {$this->table}
            LEFT JOIN {$this->tableRole} ON {$this->tableRole}.id =  {$this->table}.fk_role_id
            WHERE {$this->table}.id = :id;
        ";
            
            $condition = [':id' => $id];
            $dataType  = 1;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                return $this->userObjectBinder($result[0]);
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param string $email
         * @return bool|User
         */
        public function selectUserByMail(string $email)
        {
            $sql = "
            SELECT  {$this->table}.id, 
                    {$this->table}.user_name, 
                    {$this->table}.email, 
                    {$this->table}.email_verified, 
                    {$this->table}.password_hash, 
                    {$this->table}.first_name, 
                    {$this->table}.last_name, 
                    {$this->table}.created_at,
                    {$this->table}.updated_at,
                    {$this->table}.last_login_at,
                    {$this->table}.banned,
                    {$this->table}.number_reviews,
                    {$this->table}.fk_role_id,
                    {$this->tableRole}.id,
                    {$this->tableRole}.name,
                    {$this->tableRole}.description
            FROM {$this->table}
            LEFT JOIN {$this->tableRole} ON {$this->tableRole}.id =  {$this->table}.fk_role_id
            WHERE {$this->table}.email = :email;
        ";
            
            $condition = [':email' => $email];
            $dataType  = 2;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                return $this->userObjectBinder($result[0]);
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param string $userName
         * @return bool|User
         */
        public function selectUserByUserName(string $userName): User
        {
            $sql = "
            SELECT  {$this->table}.id, 
                    {$this->table}.user_name, 
                    {$this->table}.email, 
                    {$this->table}.email_verified, 
                    {$this->table}.password_hash, 
                    {$this->table}.first_name, 
                    {$this->table}.last_name, 
                    {$this->table}.created_at,
                    {$this->table}.updated_at,
                    {$this->table}.last_login_at,
                    {$this->table}.banned,
                    {$this->table}.number_reviews,
                    {$this->table}.fk_role_id,
                    {$this->tableRole}.id,
                    {$this->tableRole}.name,
                    {$this->tableRole}.description
            FROM {$this->table}
            WHERE {$this->table}.user_name = :username;
        ";
            
            $condition = [':username' => $userName];
            $dataType  = 2;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                return $this->userObjectBinder($result[0]);
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param AuthenticationToken $authToken
         * @return bool|User
         */
        public function selectUserByToken(AuthenticationToken $authToken)
        {
            $sql = "
            SELECT  {$this->tableToken}.id, 
                    {$this->table}.id, 
                    {$this->table}.user_name, 
                    {$this->table}.email, 
                    {$this->table}.email_verified, 
                    {$this->table}.password_hash, 
                    {$this->table}.first_name, 
                    {$this->table}.last_name, 
                    {$this->table}.created_at,
                    {$this->table}.updated_at,
                    {$this->table}.last_login_at,
                    {$this->table}.banned,
                    {$this->table}.number_reviews,
                    {$this->table}.fk_role_id,
                    {$this->tableRole}.id,
                    {$this->tableRole}.name,
                    {$this->tableRole}.description
            FROM {$this->tableToken}
              LEFT JOIN {$this->table} 
                ON {$this->table}.id = {$this->tableToken}.fk_user_id 
            WHERE {$this->tableToken}.id = :tokenId;
        ";
            
            $condition = [':tokenId' => $authToken->getId()];
            $dataType  = 1;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                return $this->userObjectBinder($result[0]);
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param Role $role
         * @return bool|User[]
         */
        public function selectUsersByRole(Role $role): array
        {
            $users = [];
            
            $sql = "
            SELECT  {$this->tableToken}.id, 
                    {$this->table}.id, 
                    {$this->table}.user_name, 
                    {$this->table}.email, 
                    {$this->table}.email_verified, 
                    {$this->table}.password_hash, 
                    {$this->table}.first_name, 
                    {$this->table}.last_name, 
                    {$this->table}.created_at,
                    {$this->table}.updated_at,
                    {$this->table}.last_login_at,
                    {$this->table}.banned,
                    {$this->table}.number_reviews,
                    {$this->table}.fk_role_id,
                    {$this->tableRole}.id,
                    {$this->tableRole}.name,
                    {$this->tableRole}.description
            FROM {$this->table}
            LEFT JOIN {$this->table} 
                ON {$this->table}.id = {$this->tableToken}.fk_user_id 
            WHERE {$this->table}.fk_role_id = :userRole;
        ";
            
            $condition = [':userRole' => $role->getId()];
            $dataType  = 1;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                foreach ($result as $user) {
                    array_push($users, $this->userObjectBinder($user));
                }
                return $users;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param bool $banned
         * @return bool|User[]
         */
        public function selectUsersBanned(bool $banned): array
        {
            $users = [];
            
            $sql = "
            SELECT  {$this->tableToken}.id, 
                    {$this->table}.id, 
                    {$this->table}.user_name, 
                    {$this->table}.email, 
                    {$this->table}.email_verified, 
                    {$this->table}.password_hash, 
                    {$this->table}.first_name, 
                    {$this->table}.last_name, 
                    {$this->table}.created_at,
                    {$this->table}.updated_at,
                    {$this->table}.last_login_at,
                    {$this->table}.banned,
                    {$this->table}.number_reviews,
                    {$this->table}.fk_role_id,
                    {$this->tableRole}.id,
                    {$this->tableRole}.name,
                    {$this->tableRole}.description
            FROM {$this->table}
            LEFT JOIN {$this->table} 
                ON {$this->table}.id = {$this->tableToken}.fk_user_id
            WHERE {$this->table}.banned = :banned;
        ";
            
            $condition = [':banned' => $banned];
            $dataType  = 5;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                foreach ($result as $user) {
                    array_push($users, $this->userObjectBinder($user));
                }
                return $users;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param User $user
         * @return bool|int
         */
        public function insertUser(User $user)
        {
            $data = [
                'user_name'      => [$user->getUserName(), 2],
                'email'          => [$user->getEmail(), 2],
                'email_verified' => [$user->isEmailVerified(), 5],
                'password_hash'  => [$user->getPasswordHash(), 2],
                'first_name'     => [$user->getFirstName(), 2],
                'last_name'      => [$user->getLastName(), 2],
                'created_at'     => [$user->getCreatedAt(), 2],
                'updated_at'     => [$user->getUpdatedAt(), 2],
                'last_login_at'  => [$user->getLastLoginAt(), 2],
                'banned'         => [$user->isBanned(), 5],
                'number_reviews' => [$user->getNumberReviews(), 1],
                'fk_role_id'     => [$user->getRole()->getId(), 1],
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
         * @param User $user
         * @return bool|int
         */
        public function updateUser(User $user)
        {
            $data = [
                'user_name'      => [$user->getUserName(), 2],
                'email'          => [$user->getEmail(), 2],
                'email_verified' => [$user->isEmailVerified(), 5],
                'password_hash'  => [$user->getPasswordHash(), 2],
                'first_name'     => [$user->getFirstName(), 2],
                'last_name'      => [$user->getLastName(), 2],
                'created_at'     => [$user->getCreatedAt(), 2],
                'updated_at'     => [$user->getUpdatedAt(), 2],
                'last_login_at'  => [$user->getLastLoginAt(), 2],
                'banned'         => [$user->isBanned(), 5],
                'number_reviews' => [$user->getNumberReviews(), 1],
                'fk_role_id'     => [$user->getRole()->getId(), 1],
            ];
            
            $condition = "{$this->table}.id = :id";
            
            $result = $this->update($this->table, $data, $condition, $user->getId());
            
            if (is_int($result)) {
                return $result;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            return false;
        }
        
        /**
         * @param User $user
         * @return bool|int
         */
        public function deleteUser(User $user)
        {
            $condition = "{$this->table}.id = :id";
            
            $result = $this->delete($this->table, $condition, $user->getId());
            
            if (is_int($result)) {
                return $result;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
    }