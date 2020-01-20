<?php
    
    
    namespace w2w\DAO\PDO;
    
    
    use w2w\Model\Message;
    use DateTime;
    
    class MessageDAO extends PDOGenericDAO
    {
        private $table = 'messages';
        
        /**
         * MessageDAO constructor.
         */
        public function __construct()
        {
            parent::__construct();
        }
        
        /**
         * messageObjectBinder
         * @param array $messageArray
         * @return bool|Message
         */
        public function messageObjectBinder(array $messageArray)
        {
            if (isset($messageArray['id']) && isset($messageArray['last_name']) && isset($messageArray['email']) && isset($messageArray['content']) && isset($messageArray['created_at']) && isset($messageArray['treated'])) {
                $message = new Message(
                    $messageArray['id'],
                    $messageArray['last_name'],
                    $messageArray['email'],
                    $messageArray['content'],
                    $messageArray['created_at'],
                    $messageArray['treated'],
                );
                
                if (isset($messageArray['first_name'])) {
                    $message->setFirstName($messageArray['first_name']);
                }
                return $message;
            } else {
                return false;
            }
        }
        
        
        /**
         * @return bool|Message[]
         */
        public function selectAllMessages()
        {
            $messages = [];
            
            $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name, 
                       {$this->table}.last_name,
                       {$this->table}.email,
                       {$this->table}.content,
                       {$this->table}.created_at,
                       {$this->table}.treated
                FROM {$this->table}
                ORDER BY {$this->table}.created_at;  
        ";
            
            $result = $this->select($sql);
            
            if (is_array($result)) {
                foreach ($result as $message) {
                    array_push($messages, $this->messageObjectBinder($message));
                }
                return $messages;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        
        /**
         * @param string $name
         * @return bool|Message[]
         */
        public function selectMessagesByName(string $name)
        {
            $messages = [];
            $sql      = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name,
                       {$this->table}.last_name,
                       {$this->table}.email,
                       {$this->table}.content,
                       {$this->table}.created_at,
                       {$this->table}.treated
                FROM {$this->table}
                WHERE {$this->table}.first_name = :name 
                        OR {$this->table}.last_name = :name
                ORDER BY {$this->table}.created_at;  
        ";
            
            $condition = [':name' => $name];
            $dataType  = 2;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                foreach ($result as $message) {
                    array_push($messages, $this->messageObjectBinder($message));
                }
                return $messages;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param string $email
         * @return bool|Message[]
         */
        public function selectMessagesByEmail(string $email)
        {
            $messages = [];
            
            $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name,
                       {$this->table}.last_name,
                       {$this->table}.email,
                       {$this->table}.content,
                       {$this->table}.created_at,
                       {$this->table}.treated
                FROM {$this->table}
                WHERE {$this->table}.email = :email
                ORDER BY {$this->table}.created_at;  
        ";
            
            $condition = [':email' => $email];
            $dataType  = 2;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                foreach ($result as $message) {
                    array_push($messages, $this->messageObjectBinder($message));
                }
                return $messages;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param string $keyword
         * @return bool|Message[]
         */
        public function selectMessagesByKeyword(string $keyword)
        {
            $messages = [];
            
            $needle = "%$keyword%";
            
            $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name,
                       {$this->table}.last_name,
                       {$this->table}.email,
                       {$this->table}.content,
                       {$this->table}.created_at,
                       {$this->table}.treated
                FROM {$this->table}
                WHERE {$this->table}.first_name LIKE :needle
                    OR {$this->table}.last_name LIKE :needle
                    OR {$this->table}.email LIKE :needle
                    OR {$this->table}.content LIKE :needle
                    OR {$this->table}.created_at LIKE :needle
                    OR {$this->table}.treated LIKE :needle
                ORDER BY {$this->table}.created_at;  
        ";
            
            $condition = [':needle' => $needle];
            $dataType  = 2;
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                foreach ($result as $message) {
                    array_push($messages, $this->messageObjectBinder($message));
                }
                return $messages;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param DateTime $date
         * @return bool|Message[]
         */
        public function selectMessagesByDate(DateTime $date)
        {
            $messages = [];
            
            $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name,
                       {$this->table}.last_name,
                       {$this->table}.email,
                       {$this->table}.content,
                       {$this->table}.created_at,
                       {$this->table}.treated
                FROM {$this->table}
                WHERE {$this->table}.created_at = :date
                ORDER BY {$this->table}.first_name;  
        ";
            
            $condition = [':date' => $date];
            $dataType  = 2;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                foreach ($result as $message) {
                    array_push($messages, $this->messageObjectBinder($message));
                }
                return $messages;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        /**
         * @param bool $treated
         * @return bool|Message[]
         */
        public function selectMessagesByTreated(bool $treated)
        {
            $messages = [];
            
            $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name,
                       {$this->table}.last_name,
                       {$this->table}.email,
                       {$this->table}.content,
                       {$this->table}.created_at,
                       {$this->table}.treated
                FROM {$this->table}
                WHERE {$this->table}.treated = :treated
                ORDER BY {$this->table}.created_at;  
        ";
            
            $condition = [':treated' => $treated];
            $dataType  = 5;
            
            $result = $this->select($sql, $condition, $dataType);
            
            if (is_array($result)) {
                foreach ($result as $message) {
                    array_push($messages, $this->messageObjectBinder($message));
                }
                return $messages;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        
        /**
         * @param Message $message
         * @return bool|int
         */
        public function insertMessage(Message $message)
        {
            $data = [
                'first_name' => [$message->getFirstName(), 2],
                'last_name'  => [$message->getLastName(), 2],
                'email'      => [$message->getEmail(), 2],
                'content'    => [$message->getContent(), 2],
                'created_at' => [$message->getCreatedAt(), 2],
                'treated'    => [$message->isTreated(), 5],
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
         * @param Message $message
         * @return bool|int
         */
        public function updateMessage(Message $message)
        {
            $data = [
                'first_name' => [$message->getFirstName(), 2],
                'last_name'  => [$message->getLastName(), 2],
                'email'      => [$message->getEmail(), 2],
                'content'    => [$message->getContent(), 2],
                'created_at' => [$message->getCreatedAt(), 2],
                'treated'    => [$message->isTreated(), 5],
            ];
            
            $condition = "{$this->table}.id = :id";
            
            $result = $this->update($this->table, $data, $condition, $message->getId());
            
            if (is_int($result)) {
                return $result;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            return false;
        }
        
        /**
         * @param Message $message
         * @return bool|int
         */
        public function deleteMessage(Message $message)
        {
            $condition = "{$this->table}.id = :id";
            
            $result = $this->delete($this->table, $condition, $message->getId());
            
            if (is_int($result)) {
                return $result;
            }
            
            /*
            * TODO : handle PDOException ?
            */
            
            return false;
        }
        
        
    }
