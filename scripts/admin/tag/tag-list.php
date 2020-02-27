<?php

//    Ensure that an admin is logged in
    if (checkAdmin()) {
//        Get all the tags from the DB
        $tagDAO = new \w2w\DAO\Doctrine\DoctrineTagDAO();
        $tags   = $tagDAO->findAll();
    }