<?php

//    Ensure that an admin is logged in
    if (checkAdmin()) {
//        Get all the categories from the DB
        $categoryDAO = new \w2w\DAO\Doctrine\DoctrineCategoryDAO();
        $categories  = $categoryDAO->findAll();
    }