<?php

use \w2w\DAO\DAOFactory;

$id = param("id");

$daoFactory = DAOFactory::getDAOFactory();
$movieDAO = $daoFactory->getMovieDAO();
$movie = $movieDAO->find($id);
