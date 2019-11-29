<?php
    /**
     * Created by PhpStorm.
     * User: Meh
     * Date: 14/11/2019
     * Time: 20:26
     */
    
    namespace w2w\DAO;
    
    use PDO;
    use PDOException;
    
    class BaseDAO
    {
        private $hostname;
        private $username;
        private $password;
        private $database;
        private $scheme;
        private $port;
        private $charset;
        private $errMode;
        private $dsn;
        private $options;
        protected $pdo;
        
        /**
         * BaseDAO constructor.
         */
        public function __construct()
        {
        }
        
        /**
         * getPDO
         * @return PDO
         */
        public function getPDO()
        {
            if (!$this->pdo) {
                $this->pdo = $this->createPDO();
            }
            return $this->pdo;
        }
        
        /**
         * createPDO
         * @return PDO|string
         */
        public function createPDO()
        {
            $hostname = \Fr\Config::get("db.hostname");
            $username = \Fr\Config::get("db.username");
            $password = \Fr\Config::get("db.password");
            $database = \Fr\Config::get("db.database");
            $scheme   = \Fr\Config::get("db.scheme", "mysql");
            $port     = \Fr\Config::get("db.port");
            $charset  = \Fr\Config::get("db.charset");
            $errMode  = \Fr\Config::get("db.errmode", \PDO::ERRMODE_EXCEPTION);
            $options  = null;
            if ($errMode) {
                $options = array(
                    \PDO::ATTR_ERRMODE => $errMode
                );
            }
            $dsn = sprintf("%s:host=%s", $scheme, $hostname);
            if ($port) {
                $dsn .= sprintf(";port=%s", $port);
            }
            if ($database) {
                $dsn .= sprintf(";dbname=%s", $database);
            }
            if ($charset) {
                $dsn .= sprintf(";charset=%s", $charset);
            }
            try {
                if ($options) {
                    $pdo = new \PDO($dsn, $username, $password, $options);
                } else {
                    $pdo = new \PDO($dsn, $username, $password);
                }
                return $pdo;
                
            } catch (\PDOEXception $e) {
                #throw new \Exception($e);
                #trigger_error($e->getMessage());
                return $e->getMessage();
            }
        }
        
        /**
         * @param string $sql : complete SQL SELECT statement
         * @param string $dataType : PDO::PARAM DATATYPE
         * @param array $conditions : associative array with the key being the named parameter and the value being the value to bind.
         *
         * @return array|PDOException|bool
         */
        public function select(string $sql, $conditions = null, string $dataType = null)
        {
            if ($pdo = $this->getPDO()) {
                $dbh = $pdo->prepare($sql);
                
                if ($conditions != null) {
                    foreach ($conditions as $key => $value) {
                        $dbh->bindValue($key, $value, $dataType);
                    }
                }
                
                try {
                    $dbh->execute();
                    return $dbh->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $exception) {
                    return $exception;
                }
            } else
                return false;
        }
        
        /**
         * @param string $table : target table where insert will take place in the DB.
         * @param array $data : associative array of the data to insert in the DB where the Key = DB column and the Value = Value to store in DB.
         *
         * @return string|PDOException : returns PDO::lastInsertId() value or PDOException
         */
        public function insert(string $table, array $data)
        {
            if ($pdo = $this->getPDO()) {
                
                $keys   = implode(', ', array_keys($data));
                $values = ':' . implode(', :', array_keys($data));
                
                $sql = "INSERT INTO $table ($keys) VALUES ($values)";
                $dbh = $pdo->prepare($sql);
                
                foreach ($data as $key => $value) {
                    if (isset($value[1])) {
                        $dbh->bindValue($key, $value[0], $value[1]);
                    } else {
                        $dbh->bindValue($key, $value);
                    }
                }
                
                try {
                    $dbh->execute();
                    return $pdo->lastInsertId();
                } catch (PDOException $exception) {
                    return $exception;
                }
            } else {
                return false;
            }
        }
        
        /**
         * @param string $table : target table where update will take place in the DB.
         * @param array $data : associative array of the data to update in the DB where the Key = DB column and the Value = Value to store in DB.
         * @param string $condition : SQL condition syntax ie. "someColumn = {$someValue} AND anotherColumn = {$someOtherValue}"
         * @param int $updateId : Id of the element to update
         *
         * @return bool|PDOException : returns PDO::rowCount() value or PDOException
         *
         * TODO : Add condition flexibility
         */
        public function update(string $table, array $data, string $condition, int $updateId)
        {
            if ($pdo = $this->getPDO()) {
                
                $upkeys = '';
                
                foreach ($data as $key => $value) {
                    $upkeys .= "$key =:$key,";
                }
                
                $upkeys = rtrim($upkeys, ',');
                
                $sql = "UPDATE $table SET $upkeys WHERE $condition";
                
                $dbh = $pdo->prepare($sql);
                
                foreach ($data as $key => $value) {
                    if (isset($value[1])) {
                        $dbh->bindValue($key, $value[0], $value[1]);
                    } else {
                        $dbh->bindValue($key, $value);
                    }
                }
                
                $dbh->bindValue(":id", $updateId, PDO::PARAM_INT);
                
                try {
                    $dbh->execute();
                    return $dbh->rowCount();
                } catch (PDOException $exception) {
                    return $exception;
                }
            } else {
                return false;
            }
            
        }
        
        /**
         * @param string $table : target table where delete will take place in the DB.
         * @param string $condition : SQL condition syntax ie. "someColumn = {$someValue} AND anotherColumn = {$someOtherValue}"
         * @param int $deleteId : Id of the element to delete
         * @param int $deleteIdBis : Id of the element to delete
         *
         * @return bool|PDOException : returns PDO::rowCount() value or PDOException
         *
         * TODO : Add condition flexibility
         */
        
        public function delete(string $table, string $condition, int $deleteId, int $deleteIdBis = null
        )
        {
            if ($pdo = $this->getPDO()) {
                
                $sql = "DELETE FROM $table WHERE $condition";
                $dbh = $pdo->prepare($sql);
                
                $dbh->bindValue(":id", $deleteId, PDO::PARAM_INT);
                
                if (isset($deleteIdBis)) {
                    $dbh->bindValue(":idBis", $deleteIdBis, PDO::PARAM_INT);
                }
                
                try {
                    $dbh->execute();
                    return $dbh->rowCount();
                } catch (PDOException $exception) {
                    return $exception;
                }
            } else {
                return false;
            }
        }
    }