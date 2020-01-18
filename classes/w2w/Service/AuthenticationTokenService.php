<?php
    
    
    namespace w2w\Service;
    
    
    use w2w\DAO\AuthenticationTokenDAO;
    use w2w\Model\AuthenticationToken;
    use w2w\Model\User;
    
    class AuthenticationTokenService extends BaseService
    {
        private $authenticationTokenDAO;
        
        /**
         * AuthenticationTokenService constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->authenticationTokenDAO = new AuthenticationTokenDAO();
        }
        
        /**
         * getTokenByUser
         * @param User $user
         * @return bool|AuthenticationToken
         */
        public function getTokenByUser(User $user)
        {
            return $this->authenticationTokenDAO->selectTokenByUser($user);
        }
        
        /**
         * addToken
         * @param AuthenticationToken $token
         * @param User $user
         * @return bool
         */
        public function addToken(AuthenticationToken $token, User $user)
        {
            return $this->authenticationTokenDAO->insertToken($token, $user);
        }
        
        
    }