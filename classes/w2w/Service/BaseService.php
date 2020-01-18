<?php
/**
 * Classe de base dont doivent hériter toutes les classes Service
 * 
 * À noter que toutes les importations depuis l'espace de nom "w2w\DAO" 
 * sont des interfaces, à l'exception de l'objet DAOFactory, 
 * dont la responsabilité est justement de renovyer des 
 * implémentations des différents interfaces de DAO. 
 * Le but est un couplage faible entre les services et les DAO 
 * ("programmation à l'interface", "par contrat").
 * 
 * Dans les services, on évitera donc des instructions telles que (NOT TO DO):
 *      new \w2w\DAO\Doctrine\DoctrineUserDAO();
 *      new \w2w\DAO\PDO\PDOUserDAO();
 *      new \w2w\DAO\...
 * Parce que ces opérations créent un couplage fort, 
 * c'est-à-dire des dépendances à des implémentations particulières.
 * 
 * À la place, on appellera les méthodes proposées par cette classe de base :
 *      $this->getUserDAO();
 *      $this->getMovieDAO();
 *      
 * 
 * Created by PhpStorm.
 * User: Meh
 * Date: 14/11/2019
 * Time: 20:26
 */

namespace w2w\Service;

use w2w\DAO\DAOFactory;
use w2w\DAO\ArtistDAO;
use w2w\DAO\AuthenticationTokenDAO;
use w2w\DAO\CategoryDAO;
use w2w\DAO\MessageDAO;
use w2w\DAO\MovieDAO;
use w2w\DAO\RatingDAO;
use w2w\DAO\ReportDAO;
use w2w\DAO\ReviewDAO;
use w2w\DAO\RoleDAO;
use w2w\DAO\TagDAO;
use w2w\DAO\UserDAO;
use w2w\Model\Review;

class BaseService
{
    
    protected $daoFactory;

    /**
     * BaseService constructor.
     */
    public function __construct()
    {
    }
    
    protected function getDAOFactory(): DAOFactory
    {
        if (! $this->daoFactory) {
            $this->daoFactory = DAOFactory::getDAOFactory();
        }
        return $this->daoFactory;
    }
    
    protected function getArtistDAO(): ArtistDAO
    {
        return $this->getDAOFactory()->getArtistDAO();
    }
    
    protected function getAuthenticationTokenDAO(): AuthenticationTokenDAO
    {
        return $this->getDAOFactory()->getAuthenticationTokenDAO();
    }
    
    protected function getCategoryDAO(): CategoryDAO
    {
        return $this->getDAOFactory()->getCategoryDAO();
    }
    
    protected function getMessageDAO(): MessageDAO
    {
        return $this->getDAOFactory()->getMessageDAO();
    }
    
    protected function getMovieDAO(): MovieDAO
    {
        return $this->getDAOFactory()->getMovieDAO();
    }
    
    protected function getRatingDAO(): RatingDAO
    {
        return $this->getDAOFactory()->getRatingDAO();
    }
    
    protected function getReportDAO(): ReportDAO
    {
        return $this->getDAOFactory()->getReportDAO();
    }
    
    protected function getReviewDAO(): ReviewDAO
    {
        return $this->getDAOFactory()->getReviewDAO();
    }
    
    protected function getRoleDAO(): RoleDAO
    {
        return $this->getDAOFactory()->getRoleDAO();
    }
    
    protected function getTagDAO(): TagDAO
    {
        return $this->getDAOFactory()->getTagDAO();
    }
    
    protected function getUserDAO(): UserDAO
    {
        return $this->getDAOFactory()->getUserDAO();
    }

}
