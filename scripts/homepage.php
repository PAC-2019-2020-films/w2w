<?php

/**
 * script de la page d'accueil du site
 */

use \w2w\DAO\DAOFactory;


$lastMoviesNumber = 3;
$popularMoviesNumber = 10;

$daoFactory = DAOFactory::getDAOFactory();

$movieDAO = $daoFactory->getMovieDAO();
$lastMovies = $movieDAO->findLast($lastMoviesNumber);
$popularMovies = $movieDAO->findBest($popularMoviesNumber);


//$tagDAO = $daoFactory->getTagDAO();
//$tags = $tagDAO->findAll();

//$categoryDAO = $daoFactory->getCategoryDAO();
//$categories = $categoryDAO->findAll();

