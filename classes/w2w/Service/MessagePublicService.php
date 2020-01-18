<?php
    
    
    namespace w2w\Service;
    
    
    use \w2w\DAO\MessageDAO;
    use \w2w\Model\Message;
    
    use DateTime;
    
    class MessagePublicService extends BaseService
    {
        private $messageDAO;
        
        /**
         * MessagePublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->messageDAO = new MessageDAO();
        }
        
        /**
        * getAllMessages
        * @return bool|Message[]
        */
        public function getAllMessages()
        {
            return $this->messageDAO->selectAllMessages();
        }
        
        /**
        * getMessagesByName
        * @param string $name
        * @return bool|Message[]
        */     
        public function getMessagesByName(string $name)
        {
            return $this->messageDAO->selectMessagesByName($name);
        }
        
        /**
        * getMessagesByEmail
        * @param string $email
        * @return bool|Message[]
        */    
        public function getMessagesByEmail(string $email)
        {
            return $this->messageDAO->selectMessagesByEmail($email);
        }
        
        /**
        * getMessagesByKeyword
        * @param string $keyword
        * @return bool|Message[]
        */    
        public function getMessagesByKeyword(string $keyword)
        {
            return $this->messageDAO->selectMessagesByKeyword($keyword);
        }
        
        /**
        * getMessagesByDate
        * @param DateTime $date
        * @return bool|Message[]
        */
        public function getMessagesByDate(DateTime $date)
        {
            return $this->messageDAO->selectMessagesByDate($date);
        }
        
        /**
        * getMessagesByTreated
        * @param bool $treated
        * @return bool|Message[]
        */
        public function getMessagesByTreated(bool $treated)
        {
            return $this->messageDAO->selectMessagesByTreated($treated);
        }
        
    }