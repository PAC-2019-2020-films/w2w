<?php

/**
 * script de la page d'accueil du site
 */

use \w2w\DAO\DAOFactory;


$daoFactory = DAOFactory::getDAOFactory();

$movieDAO = $daoFactory->getMovieDAO();
$movies = $movieDAO->findAll();

$tagDAO = $daoFactory->getTagDAO();
$tags = $tagDAO->findAll();

$categoryDAO = $daoFactory->getCategoryDAO();
$categories = $categoryDAO->findAll();

