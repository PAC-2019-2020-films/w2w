<?php
/**
 * Created by PhpStorm.
 * User: Meh
 * Date: 14/11/2019
 * Time: 20:26
 */

namespace w2w\DAO\PDO;

use PDO;
use PDOException;

class PDOGenericDAO
{
    
    const PARAM_NULL = \PDO::PARAM_NULL; # = 0
    const PARAM_INT = \PDO::PARAM_INT; # = 1
    const PARAM_STR = \PDO::PARAM_STR; # = 2
    const PARAM_LOB = \PDO::PARAM_LOB; # = 3
    const PARAM_BOOL = \PDO::PARAM_BOOL; # = 5
    const PARAM_STR_NATL = \PDO::PARAM_STR_NATL;
    const PARAM_STR_CHAR = \PDO::PARAM_STR_CHAR;
    const PARAM_DATETIME = 6666; # custom param type for PHP DateTime stored as MySQL DateTime
    
    protected $tableName;
    protected $className;
    protected $generatedId = false;
    
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
    public function __construct($tableName = null, $className = null)
    {
        $this->tableName = $tableName;
        $this->className = $className;
    }
    
    public function getTableName()
    {
        return $this->tableName;
    }
    
    public function getClassName()
    {
        return $this->className;
    }
    
    public function setGeneratedId($generatedId = true)
    {
        return $this->generatedId = $generatedId;
    }
    
    public function hasGeneratedId()
    {
        return $this->generatedId;
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
        $errMode  = \Fr\Config::get("db.errmode", PDO::ERRMODE_EXCEPTION);
        $options  = null;
        if ($errMode) {
            $options = array(
                PDO::ATTR_ERRMODE => $errMode
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
                $pdo = new PDO($dsn, $username, $password, $options);
            } else {
                $pdo = new PDO($dsn, $username, $password);
            }
            return $pdo;
            
        } catch (PDOEXception $e) {
            #throw new \Exception($e);
            #trigger_error($e->getMessage());
//                var_dump($e->getMessage());
//                die();
            return $e->getMessage();
        }
    }











    /**
     * prepared statements....
     * 
     * !!!  If you do not fetch all of the data in a result set before
     * issuing your next call to PDO::query(), your call may fail.
     * Call PDOStatement::closeCursor() to release the database resources
     * associated with the PDOStatement object before issuing your next
     * call to PDO::query().
     *
     * @return a PDOStatement object, or false on failure
     */
   public function prepareExecute($sql, $params = array())
    {
        if ($pdo = $this->getPDO()) {
            if ($statement = $pdo->prepare($sql)) {
                foreach ($params as $key => $value) {
                    if (is_array($value)) {
                        $statement->bindValue($key, $value[0], $value[1]);
                    } else {
                        $statement->bindValue($key, $value);
                    }
                }
                $statement->execute();
                return $statement;
            }
        }
        return false;
    }

    public function prepareExecuteFetch($sql, $params = array(), $fetch_style = \PDO::FETCH_BOTH)
    {
        if ($statement = $this->prepareExecute($sql, $params)) {
	        $row = $statement->fetch($fetch_style);
	        $statement->closeCursor();
	        return $row;
		}
    }

    public function prepareExecuteFetchAll($sql, $params = array(), $fetch_style = \PDO::FETCH_BOTH)
    {
        if ($statement = $this->prepareExecute($sql, $params)) {
	        $rows = $statement->fetchAll($fetch_style);
	        $statement->closeCursor();
	        return $rows;
		}
    }

    public function prepareExecuteAffectedRows($sql, $params = array())
    {
        $statement = $this->prepareExecute($sql, $params);
        $affectedRows = (int) $statement->rowCount();
        $statement->closeCursor();
        return $affectedRows;
    }

    public function prepareExecuteLastInsertId($sql, $params = array())
    {
        $affectedRows = $this->prepareExecuteAffectedRows($sql, $params);
        if ($affectedRows > 0) {
            return (int) $this->getPDO()->lastInsertId();
        }
        return $affectedRows;
    }

    public function prepareExecuteFetchArray($sql, $params = array())
    {
        $result = false;
        if ($rows = $this->prepareExecuteFetchAll($sql, $params, \PDO::FETCH_NUM)) {
            $result = array();
            foreach ($rows as $row) {
                if (isset($row[0])) {
                    $result[] = $row[0];
                }
            }
        }
        return $result;
    }

    public function prepareExecuteFetchValue($sql, $params = array())
    {
        $value = false;
        if ($statement = $this->prepareExecute($sql, $params)) {
            if ($row = $statement->fetch(\PDO::FETCH_NUM)) {
                if (isset($row[0])) {
                    $value = $row[0];
                }
            }
            $statement->closeCursor();
        }
        return $value;    
    }

    public function prepareExecuteFetchInteger($sql, $params = array())
    {
        if (($value = $this->prepareExecuteFetchValue($sql, $params)) !== false) {
            return (int) $value;
        }
        return false;
    }

    public function prepareExecuteCountRows($sql, $params = array())
    {
        $statement = $this->prepareExecute($sql, $params);
        $rows = $statement->fetchAll(\PDO::FETCH_OBJ);
        $statement->closeCursor();
        return count($rows);
    }










    // very naive implementation, must certainly be overriden...
    public function fetchFromRow($row)
    {
        $cn = $this->getClassName();
        $obj = new $cn();
        foreach ($row as $key => $value) {
            $obj->{$key} = $value;
        }
        return $obj;
    }

    public function fetchOne($sql, $params = [])
    {
        if ($row = $this->prepareExecuteFetch($sql, $params)) {
            if ($entity = $this->fetchFromRow($row)) {
                return $entity;
            }
        }
    }
    
    public function fetchMany($sql, $params = [])
    {
        if ($rows = $this->prepareExecuteFetchAll($sql, $params)) {
            $entities = [];
            foreach ($rows as $row) {
                if ($entity = $this->fetchFromRow($row)) {
                    $entities[] = $entity;
                }
            }
            return $entities;
        }
    }

    
    /**
     * @param string $sql : complete SQL SELECT statement
     * @param string $dataType : PDO::PARAM DATATYPE
     * @param array $conditions : associative array with the key being the named parameter and the value being the value to bind.
     *
     * @return array|PDOException|bool
     */
    public function select(string $sql, array $parameters = null)
    {
        
        if ($pdo = $this->getPDO()) {
            $dbh = $pdo->prepare($sql);
            
            
            if ($parameters != null) {
                if (! is_array($parameters)) {
                    throw new \InvalidArgumentException("parameters argument should be an array or null");
                }
                foreach ($parameters as $key => $parameter) {
                    if (is_array($parameter)) {
                        $parameterCount = count($parameter);
                        if ($parameterCount > 1) {
                            $dbh->bindValue($key, $parameter[0], $parameter[1]);
                        } elseif ($parameterCount > 0) {
                            $dbh->bindValue($key, $parameter[0]);
                        } else {
                            throw new \InvalidArgumentException("parameter passed as array must contain at least one element");
                        }
                    } else {
                        $dbh->bindValue($key, $parameter);
                    }
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
    public function insert(string $table, array $data, $returnLastInsertId = false)
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
     * 
     * devrait remplacer insert ci-dessus...
     * 
     * @param string $table : target table where insert will take place in the DB.
     * @param array $data : associative array of the data to insert in the DB where the Key = DB column and the Value = Value to store in DB.
     *
     * @return string|PDOException : returns PDO::lastInsertId() value or PDOException
     */
    public function genericInsert(array $data)
    {
        $keys   = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->getTableName()} ($keys) VALUES ($values)";
        if ($this->hasGeneratedId()) {
            return $this->prepareExecuteLastInsertId($sql, $data);
        } else {
            return $this->prepareExecuteAffectedRows($sql, $data);
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
    public function genericUpdate(string $table, array $data, string $condition, int $updateId)
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
    
    public function genericDelete(string $table, string $condition, int $deleteId, int $deleteIdBis = null
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


    /**
     * @Override
     */
    public function find($key)
    {
    }
    
    /**
     * @Override
     */
    public function findAll()
    {
    }
    
    /**
     * @Override
     */
    public function save($object)
    {
    }
    
    /**
     * @Override
     */
    public function update($object)
    {
    }
    
    /**
     * @Override
     */
    public function delete($object)
    {
    }

    public function max(string $property)
    {
        $sql = sprintf("SELECT MAX(%s) FROM %s", $property, $this->getTableName());
        if ($pdo = $this->getPDO()) {
            if ($stmt = $pdo->query($sql)) {
                if ($row = $stmt->fetch()) {
                    return $row[0];
                }
            }
        }
    }
    
    public function min(string $property)
    {
        $sql = sprintf("SELECT MIN(%s) FROM %s", $property, $this->getTableName());
        if ($pdo = $this->getPDO()) {
            if ($stmt = $pdo->query($sql)) {
                if ($row = $stmt->fetch()) {
                    return $row[0];
                }
            }
        }
    }
    
}
