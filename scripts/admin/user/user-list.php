<?php
use \w2w\DAO\DAOFactory;

checkAdmin();

$userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();
$users = $userDAO->findAll();
