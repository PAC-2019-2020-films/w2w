<?php
    
    
    namespace w2w\DAO\PDO;
    
    
    use w2w\Model\User;
    use w2w\Model\AuthenticationToken;
    
    class AuthenticationTokenDAO extends BaseDAO
    {
        private $table = 'authentication_tokens';
        private $userDAO;
        
        /**
         * AuthenticationTokenDAO constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->userDAO = new UserDAO();
        }
        
        /**
         * authenticationTokenObjectBinder
         * @param array $tokenArray
         * @return bool|AuthenticationToken
         */
        public function authenticationTokenObjectBinder(array $tokenArray)
        {
            if (isset($tokenArray['id']) && isset($tokenArray['email']) && isset($tokenArray['token']) && isset($tokenArray['expires_at']) && isset($tokenArray['new_password']) && isset($tokenArray['fk_user_id'])) {
                
                $token = new AuthenticationToken(
                    $tokenArray['id'],
                    $tokenArray['email'],
                    $tokenArray['token'],
                    $tokenArray['expires_at'],
                    $tokenArray['new_password'],
                    $this->userDAO->selectUserById($tokenArray['fk_user_id']),
                );
                
                return $token;
            } else {
                return false;
            }
        }
        
        
        /**
         * @param User $user
         * @return bool|AuthenticationToken
         */
        public function selectTokenByUser(User $user)
        {
            $sql = "
            SELECT  {$this->table}.id,
                    {$this->table}.email,
                    {$this->table}.token,
                    {$this->table}.expires_at,
                    {$this->table}.verified_at,
                    {$this->table}.new_password,
                    {$this->table}.fk_user_id
            FROM {$this->table}
            WHERE {$this->table}.fk_user_id = :userId;
        ";
            
            $condition = [':userId' => $user->getId()];
            $dataType  = 1;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result) && isset($result[0])) {
                return $this->authenticationTokenObjectBinder($result[0]);
            }
            
            return false;
        }
        
        /**
         * @param AuthenticationToken $token
         * @param User $user
         * @return bool|int
         */
        public function insertToken(AuthenticationToken $token, User $user)
        {
            
            $data = [
                'email'        => [$token->getEmail(), 2],
                'token'        => [$token->getToken(), 1],
                'expires_at'   => [$token->getExpiresAt(), 2],
                'verified_at'  => [$token->getVerifiedAt(), 2],
                'new_password' => [$token->getNewPassword(), 5],
                'fk_user_id'   => [$user->getId(), 1]
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
         * @param AuthenticationToken $token
         * @return bool|int
         */
        public function updateToken(AuthenticationToken $token)
        {
            $data = [
                'email'        => [$token->getEmail(), 2],
                'token'        => [$token->getToken(), 1],
                'expires_at'   => [$token->getExpiresAt(), 2],
                'verified_at'  => [$token->getVerifiedAt(), 2],
                'new_password' => [$token->getNewPassword(), 5],
                'fk_user_id'   => [$token->getUser()->getId(), 1]
            ];
            
            $condition = "{$this->table}.id = :id";
            
            $result = $this->update($this->table, $data, $condition, $token->getId());
            
            if (is_int($result)) {
                return $result;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param AuthenticationToken $token
         * @return bool|int
         */
        public function deleteToken(AuthenticationToken $token)
        {
            $condition = "{$this->table}.id = :id";
            
            $result = $this->delete($this->table, $condition, $token->getId());
            
            if (is_int($result)) {
                return $result;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        
    }
