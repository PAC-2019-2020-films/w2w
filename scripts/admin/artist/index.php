<?php

use \w2w\DAO\DAOFactory;

checkAdmin();

$daoFactory = DAOFactory::getDAOFactory();
$artistDAO = $daoFactory->getArtistDAO();
$artists = $artistDAO->findAll();
