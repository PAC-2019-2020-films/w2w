<?php

/**
 * Liste des catégories.
 * 
 */
$daoFactory = \w2w\DAO\DAOFactory::getDAOFactory();
$categoryDAO = $daoFactory->getCategoryDAO();
$categories = $categoryDAO->findAll();
