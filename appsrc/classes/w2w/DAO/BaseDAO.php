<?php
namespace w2w\DAO;

use \Fr\Config;

class BaseDAO
{

    protected $className;
    protected $tableName;
    protected $pdo;

    public function __construct($className = null, $tableName = null)
    {
        $this->className = $className;
        $this->tableName = $tableName;
    }

    public function getPDO()
    {
        if (! $this->pdo) {
            $this->pdo = $this->createPDO();
        }
        return $this->pdo;
    }

    public function createPDO()
    {
        $hostname = \Fr\Config::get("db.hostname");
        $username = \Fr\Config::get("db.username");
        $password = \Fr\Config::get("db.password");
        $database = \Fr\Config::get("db.database");
        $scheme   = \Fr\Config::get("db.scheme",    "mysql");
        $port     = \Fr\Config::get("db.port");
        $charset  = \Fr\Config::get("db.charset");
        $errMode  = \Fr\Config::get("db.errmode",   \PDO::ERRMODE_EXCEPTION);
        $options = null;
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
            $dsn .= sprintf(";charset=%s", $cCharset);
        }
        try {
	        if ($options) {
	            $pdo = new \PDO($dsn, $username, $password, $options);
	        } else {
	            $pdo = new \PDO($dsn, $username, $password);
	        }
		} catch (\PDOEXception $e) {
            #throw new \Exception($e);
			#trigger_error($e->getMessage());
        }
        return $pdo;
    }
       
    public function bindTimestampToDatetime($statement, $placeholder, $timestamp)
    {
        if ($timestamp == null) {
            $statement->bindValue($placeholder, null);
        } else {
            $statement->bindValue($placeholder, date("Y-m-d H:i:s", $timestamp));
        }
    }

}
