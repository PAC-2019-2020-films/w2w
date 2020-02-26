<?php
    
    global $user;
    
    if (checkUser()) {
        $reviewDAO = new \w2w\DAO\Doctrine\DoctrineReviewDAO();
        $reviews   = $reviewDAO->findBy('user', $user);
    
        if (checkAdmin()) {
            $allReviews = $reviewDAO->findAll();
        }
    }
    
   