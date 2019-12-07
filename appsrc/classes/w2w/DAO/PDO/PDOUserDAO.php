<?php

namespace w2w\DAO\PDO;

use w2w\DAO\UserDAO;
use w2w\Model\Role;
use w2w\Model\User;
use w2w\Model\AuthenticationToken;

class PDOUserDAO extends PDOGenericDAO implements UserDAO
{
    private $table = 'users';
    private $tableRole = 'roles';
    private $tableToken = 'authentication_tokens';
    
    //private $roleDAO;
    
    /**
     * UserDAO constructor.
     */
    public function __construct()
    {
        parent::__construct("users", "\\w2w\\Model\\User");
        //$this->roleDAO = new RoleDAO();
    }


    /**
     * @param string $email
     * @return bool|User
     */
    public function findByEmail(string $email)
    {
    }
    
    /**
     * @param string $userName
     * @return bool|User
     */
    public function findByUserName(string $userName): User
    {
    }
    
    /**
     * @param AuthenticationToken $authToken
     * @return bool|User
     */
    public function findByToken(AuthenticationToken $authToken)
    {
    }
    
    /**
     * @param Role $role
     * @return bool|User[]
     */
    public function findByRole(Role $role): array
    {
    }

    /**
     * @param bool $banned
     * @return bool|User[]
     */
    public function findByBanned(bool $banned): array
    {
    }
        
        
        
        
        

    /**
     * conversion nom de colonne SQL en nom d'attribut d'objet PHP selon convention :
     * ex : user_name => userName
     */
    public function col2prop($attr)
    {
        $prop = "";
        $len = strlen($attr);
        for ($i = 0 ; $i < $len ; $i++) {
            if (($i > 0 && $attr[$i - 1] == "_")) {
                $prop .= strtoupper($attr[$i]);
            } elseif ($attr[$i] == "_") {
            } else {
                $prop .= $attr[$i];
            }
        }
        return $prop;
    }

    public function fetchFromColumn($item, $row, $name, $type = self::PARAM_STR)
    {
        if (isset($row[$name])) {
            $setterName = "set" . ucfirst($this->col2prop($name));
            if (method_exists($item, $setterName)) {
                if ($type == self::PARAM_DATETIME) {
                    $item->{$setterName}(new \DateTime($row[$name]));
                } else {
                    $item->{$setterName}($row[$name]);
                }
            }
        }
    }
    
    public function fetchFromRow($row)
    {
        $cn = $this->getClassName();
        $item = new $cn();
        $this->fetchFromColumn($item, $row, "id");
        $this->fetchFromColumn($item, $row, "user_name");
        $this->fetchFromColumn($item, $row, "email");
        $this->fetchFromColumn($item, $row, "email_verified");
        $this->fetchFromColumn($item, $row, "password_hash");
        $this->fetchFromColumn($item, $row, "first_name");
        $this->fetchFromColumn($item, $row, "last_name");
        $this->fetchFromColumn($item, $row, "created_at", self::PARAM_DATETIME);
        $this->fetchFromColumn($item, $row, "updated_at", self::PARAM_DATETIME);
        $this->fetchFromColumn($item, $row, "last_login_at", self::PARAM_DATETIME);
        $this->fetchFromColumn($item, $row, "banned");
        $this->fetchFromColumn($item, $row, "number_reviews");
        if (isset($row["role_id"]) && isset($row["role_name"]) && isset($row["role_description"])) {
            $item->setRole(new Role($row["role_id"], $row["role_name"], $row["role_description"]));
        }
        return $item;
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
                $userArray['first_name'],
                $userArray['last_name'],
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
     * return base SQL request for join request on 'users' and 'roles' tables
     */
    public function getSqlSelect()
    {
        $sql = "SELECT  user.id, 
                    user.user_name, 
                    user.email, 
                    user.email_verified, 
                    user.password_hash, 
                    user.first_name, 
                    user.last_name, 
                    user.created_at,
                    user.updated_at,
                    user.last_login_at,
                    user.banned,
                    user.number_reviews,
                    user.fk_role_id,
                    role.id AS role_id,
                    role.name AS role_name,
                    role.description AS role_description
                FROM %s AS user
                LEFT JOIN %s AS role ON user.fk_role_id=role.id";
        return sprintf($sql, $this->getTableName(), $this->tableRole);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /**
     * @return bool|User[]
     */
    public function selectAllUsers(): array
    {
        
        $sql = $this->getSqlSelect() . " ORDER BY user.id";
        return $this->fetchMany($sql);
        
        
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
        $sql = $this->getSqlSelect() . " WHERE user.id=:id";
        return $this->fetchOne($sql, [':id' => [$id, self::PARAM_INT]]);


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
    public function selectUserByEmail(string $email)
    {
        $sql = $this->getSqlSelect() . " WHERE user.email=:email";
        return $this->fetchOne($sql, [':email' => $email]);

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
