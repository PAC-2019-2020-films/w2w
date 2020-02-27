<?php
use \w2w\DAO\DAOFactory;

checkAdmin();

$daoFactory = DAOFactory::getDAOFactory();
$messageDAO = $daoFactory->getMessageDAO();
$untreated = $messageDAO->findByTreated(false);
$treated = $messageDAO->findByTreated(true);
