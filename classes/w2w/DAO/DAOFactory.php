<?php

namespace w2w\DAO;

use w2w\DAO\Doctrine\DoctrineDAOFactory;
use w2w\DAO\PDO\PDODAOFactory;

/**
 *
 */
abstract class DAOFactory
{

    public const PDO = "pdo";
    public const DOCTRINE = "doctrine";
    public const DEFAULT = self::DOCTRINE;
    
    public static function getDAOFactory($name = null)
    {
        if ($name === null) {
            $name = self::DEFAULT;
        }
        switch (strtolower($name)) {
            case self::PDO :
                return new PDODAOFactory();
                break;
            case self::DOCTRINE :
                return new DoctrineDAOFactory();
                break;
            default :
                throw new \Exception("Can't instantiate DAOFactory (name='{$name}')");
        }
    }
    
    public abstract function getArtistDAO();
    public abstract function getAuthenticationTokenDAO();
    public abstract function getCategoryDAO();
    public abstract function getMessageDAO();
    public abstract function getMovieActorDAO();
    public abstract function getMovieDAO();
    public abstract function getMovieDirectorDAO();
    public abstract function getMovieTagDAO();
    public abstract function getRatingDAO();
    public abstract function getReportDAO();
    public abstract function getReviewDAO();
    public abstract function getRoleDAO();
    public abstract function getTagDAO();
    public abstract function getUserDAO();
    
}
