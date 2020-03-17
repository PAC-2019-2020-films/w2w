<?php

//    Ensure that a user is logged in
global $user;

if (checkAdmin()) {
//        Get all the reviews of the user
    $reportDAO = new \w2w\DAO\Doctrine\DoctrineReportDAO();
    $reports   = $reportDAO->findAll();

}

