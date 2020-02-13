<?php


checkAdmin();

$tagDAO = new \w2w\DAO\Doctrine\DoctrineTagDAO();
$tags = $tagDAO->findAll();
