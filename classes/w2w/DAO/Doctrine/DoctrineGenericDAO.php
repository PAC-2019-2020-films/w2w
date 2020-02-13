<?php

namespace w2w\DAO\Doctrine;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use w2w\DAO\GenericDAO;

/**
 *
 */
class DoctrineGenericDAO implements GenericDAO
{

    protected static $entityManager;
    
    protected $entityClassName; # fully qualified name of mapped entity

    public function __construct($entityClassName)
    {
        $this->entityClassName = $entityClassName;
    }

    public function getEntityName()
    {
        return $this->entityClassName;
    }


    public function getEntityManager()
    {
        if (self::$entityManager == null) {
            self::$entityManager = $this->createEntityManager();
        }
        return self::$entityManager;
    }

    public function createEntityManager()
    {
        // chemin vers classes des entitées mappées :
        $paths = array(FR_CLASS_PATH . "/w2w/Model");
        $isDevMode = FR_DEBUG;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        // the connection configuration
        $dbParams = array(
            "driver"   => DB_DRIVER,
            "user"     => DB_USERNAME,
            "password" => DB_PASSWORD,
            "dbname"   => DB_DATABASE,
        );
        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, $proxyDir, $cache);//, $useSimpleAnnotationReader);
        $em = EntityManager::create($dbParams, $config);
        return $em;
    }

    /**
     * @Override
     */
    public function find($key)
    {
        if ($em = $this->getEntityManager()) {
            return $em->find($this->entityClassName, $key);
        }
    }

    /**
     * @Override
     */
    public function findAll()
    {
        if ($em = $this->getEntityManager()) {
            if ($repo = $em->getRepository($this->entityClassName)) {
                return $repo->findAll();
            }
        }
    }

    /**
     * @Override
     */
    public function save($object)
    {
        if ($em = $this->getEntityManager()) {
            $em->persist($object);
            $em->flush();
            return true;
        }
        return false;
    }

    /**
     * @Override
     */
    public function update($object)
    {
        if ($em = $this->getEntityManager()) {
            $em->persist($object);
            $em->flush();
            return true;
        }
        return false;
    }

    /**
     * @Override
     */
    public function delete($object)
    {
        if ($em = $this->getEntityManager()) {
            if (! is_object($object)) {
                $object = $em->find($this->entityClassName, $object);
            }
            if (is_object($object)) {
                $em->remove($object);
                $em->flush();
                return true;
            }
        }
        return false;
    }

    public function findOneBy($keyName, $keyValue)
    {
        if ($em = $this->getEntityManager()) {
            return $em->getRepository($this->entityClassName)->findOneBy([$keyName => $keyValue]);
        }
    }

    public function findBy($keyName, $keyValue)
    {
        if ($em = $this->getEntityManager()) {
            return $em->getRepository($this->entityClassName)->findBy([$keyName => $keyValue]);
        }
    }

    public function flush()
    {
        if ($em = $this->getEntityManager()) {
            return $em->flush();
        }
    }

	public function count()
    {
        $className = "\\" . $this->entityClassName;
		$dql = sprintf("SELECT count(item) FROM %s item", $className);
		return $this->getEntityManager()->createQuery($dql)->getSingleScalarResult();
	}

	public function deleteAll($reset = false)
    {
        $className = $this->entityClassName;
        //echo sprintf("deleting table for entity '%s'...\n", $className);
		$dql = sprintf("DELETE %s", $className);
		$res = $this->getEntityManager()->createQuery($dql)->execute();
        if ($reset) {
            $this->resetAutoIncrement();
        }
        return $res;
	}

	public function resetAutoIncrement()
    {
        $className = "\\" . $this->entityClassName;
        $tableName = $this->getEntityManager()->getClassMetadata($className)->getTableName();
        $sql = sprintf("ALTER TABLE %s AUTO_INCREMENT = 1;", $tableName);
        $stmt = $this->getEntityManager()->getConnection()->query("ALTER TABLE $tableName AUTO_INCREMENT = 1;");
        return $stmt;
	}
    
    
    
    public function max(string $property)
    {
        if ($em = $this->getEntityManager()) {
            $value = $em->createQueryBuilder()
                ->select("MAX(e.$property)")
                ->from($this->entityClassName, "e")
                ->getQuery()
                ->getSingleScalarResult();    
            return $value;
        }
    }
    
    public function min(string $property)
    {
        if ($em = $this->getEntityManager()) {
            $value = $em->createQueryBuilder()
                ->select("MIN(e.$property)")
                ->from($this->entityClassName, "e")
                ->getQuery()
                ->getSingleScalarResult();    
            return $value;
        }
    }
    
    public function exec($sql)
    {
        if ($em = $this->getEntityManager()) {
            return $em->getConnection()->exec($sql);
        }
    }

}
