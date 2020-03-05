<?php

//    Ensure that a user is logged in
    global $user;
    
    if (checkUser()) {
//        Get all the reviews of the user
        $reviewDAO = new \w2w\DAO\Doctrine\DoctrineReviewDAO();
        $reviews   = $reviewDAO->findBy('user', $user);
        
        
    
//        If the user is admin we fetch every reviews
        if ($user->isAdmin()) {
            $allReviews = $reviewDAO->findAll();
        }
    }
    
   