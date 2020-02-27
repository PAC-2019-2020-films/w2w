<?php

/**
 * Liste des catégories.
 * 
 */
$daoFactory = \w2w\DAO\DAOFactory::getDAOFactory();
$ratingDAO = $daoFactory->getRatingDAO();
$ratings = $ratingDAO->findAll();
