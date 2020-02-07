<?php

checkAdmin();

$categoryDAO = new \w2w\DAO\Doctrine\DoctrineCategoryDAO();
$categories = $categoryDAO->findAll();


