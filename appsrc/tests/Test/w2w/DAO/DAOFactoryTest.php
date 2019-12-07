<?php

namespace Test\w2w\DAO;

use \Test\BaseTestCase;
use \w2w\DAO\DAOFactory;


use \w2w\DAO\MovieDirectorDAO;
use \w2w\DAO\MovieTagDAO;
use \w2w\DAO\RatingDAO;
use \w2w\DAO\ReportDAO;
use \w2w\DAO\ReviewDAO;
use \w2w\DAO\RoleDAO;
use \w2w\DAO\TagDAO;
use \w2w\DAO\UserDAO;

use \w2w\DAO\Doctrine\DoctrineDAOFactory;
use \w2w\DAO\PDO\PDODAOFactory;

class DAOFactoryTest extends BaseTestCase
{
   
    protected $daoNames = ["Artist", "AuthenticationToken", "Category", "Message", "MovieActor", "Movie", "MovieDirector", "MovieTag", "Rating", "Report", "Review", "Role", "Tag", "User"];

    public function testGetDAOFactory()
    {
        $daoFactory = DAOFactory::getDAOFactory();
        $this->assertInstanceOf(DAOFactory::class, $daoFactory);

        $daoFactory = DAOFactory::getDAOFactory(DAOFactory::DOCTRINE);
        $this->assertInstanceOf(DoctrineDAOFactory::class, $daoFactory);

        $daoFactory = DAOFactory::getDAOFactory(DAOFactory::PDO);
        $this->assertInstanceOf(PDODAOFactory::class, $daoFactory);
    }

    public function testDAOGettersWithDefaultImplementation()
    {
        $daoFactory = DAOFactory::getDAOFactory();
        $cpt = 0;
        $tot = count($this->daoNames);
        foreach ($this->daoNames as $daoName) {
            $daoFQCN = sprintf("\\w2w\\DAO\\%sDAO", $daoName);
            $daoGetter = sprintf("get%sDAO", $daoName);
            echo sprintf("%d/%d : getting %s instance with %s getter\n", ++$cpt, $tot, $daoFQCN, $daoGetter);
            $dao = $daoFactory->{$daoGetter}();
            $this->assertInstanceOf($daoFQCN, $dao);
            
        }
    }

    public function testDAOGettersWithDoctrineImplementation()
    {
        $daoFactory = DAOFactory::getDAOFactory(DAOFactory::DOCTRINE);
        $cpt = 0;
        $tot = count($this->daoNames);
        foreach ($this->daoNames as $daoName) {
            $daoFQCN = sprintf("\\w2w\\DAO\\%sDAO", $daoName);
            $daoGetter = sprintf("get%sDAO", $daoName);
            echo sprintf("%d/%d : getting %s instance with %s getter\n", ++$cpt, $tot, $daoFQCN, $daoGetter);
            $dao = $daoFactory->{$daoGetter}();
            $this->assertInstanceOf($daoFQCN, $dao);
            
        }
    }

    public function _testDAOGettersWithPDOImplementation()
    {
        $tmp = $this->daoNames;
        $this->daoNames = ["Artist", "Role", "User"];
        
        $daoFactory = DAOFactory::getDAOFactory(DAOFactory::PDO);
        $cpt = 0;
        $tot = count($this->daoNames);
        foreach ($this->daoNames as $daoName) {
            $daoFQCN = sprintf("\\w2w\\DAO\\%sDAO", $daoName);
            $daoGetter = sprintf("get%sDAO", $daoName);
            echo sprintf("%d/%d : getting %s instance with %s getter\n", ++$cpt, $tot, $daoFQCN, $daoGetter);
            $dao = $daoFactory->{$daoGetter}();
            $this->assertInstanceOf($daoFQCN, $dao);
            
        }
        
        $this->daoNames = $tmp;
    }

}
