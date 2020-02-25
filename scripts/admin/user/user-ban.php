<?php

$userId = param('id');

$userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();
$user = $userDAO->findOneBy('id', $userId);

var_dump($user);
die();