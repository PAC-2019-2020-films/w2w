<?php

//    Ensure that an admin is logged in
    if (checkAdmin()) {
//        Get all the users from the DB
//        Post project : sensitive data should be filtered in DAO/DB layer
        $userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();
        $users   = $userDAO->findAll();
    }