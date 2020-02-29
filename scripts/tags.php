<?php

/**
 * Liste des catégories.
 * 
 */
$daoFactory = \w2w\DAO\DAOFactory::getDAOFactory();
$tagDAO = $daoFactory->getTagDAO();
$tags = $tagDAO->findAll();
