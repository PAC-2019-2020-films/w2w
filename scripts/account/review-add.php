<?php

//    Ensure that a user is logged in
    global $user;
    
    if (checkUser()) {
    
//        Get the review data from the submitted form
        $movieId  = param('movieId');
        $comment  = param('comment');
        $ratingId = param("rating");
        
//        Validate the data
        $rawInput = [
            'movie'   => ["num", $movieId, false],
            'comment' => ['ckedit', $comment, false],
            'rating'  => ['num', $ratingId, false]
        ];
        
        if (\w2w\Utils\Utils::inputValidation($rawInput)) {
            
            $reviewDAO = new \w2w\DAO\Doctrine\DoctrineReviewDAO();
            $movieDAO  = new \w2w\DAO\Doctrine\DoctrineMovieDAO();
            $ratingDAO = new \w2w\DAO\Doctrine\DoctrineRatingDAO();
            
//            Find the matching movie object in the DB
            $movie     = $movieDAO->findOneBy('id', $movieId);
//            Find the matching rating object in the DB
            $rating    = $ratingDAO->findOneBy('id', $ratingId);
//            Set createdAt at NOW
            $createdAt = new DateTime("now", new DateTimeZone("Europe/Brussels"));
          
//            If a matching movie and rating were found in the DB ("SHOULD" always be the case...)
            if (isset($movie) && isset($rating)) {
            
//                Check that the user has not already posted a review on that movie
                if (!($reviewDAO->findByUserAndMovie($user, $movie))) {
                
//                    Created a new review object with the form data
                    $review = new \w2w\Model\Review(1, $comment, $createdAt, null, $movie, $user, $rating);
                    
//                    If the user is an admin, set the review as an AdminReview in the Movie object properties
//                    There appears to be some neat magic going on here since we do not need to persist the movie object
                    if ($user->isAdmin()){
                        $movie->setAdminReview($review);
                    }
                    
//                    Save the review object in the DB
                    $reviewDAO->save($review);

//                    Get the matching user object from the DB, increment his number of reviews and save it.
                    $userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();
                    $user->setNumberReviews($user->getNumberReviews()+1);
                    $userDAO->update($user);

//                    Set the flashbag message and redirect
                    \w2w\Utils\Utils::message(true, "Votre review a été postée!", "");
                    header('Location: ../movie.php?id=' . $movieId);
                    exit();
                } else {
                    \w2w\Utils\Utils::message(false, '', 'Vous avez déjà publié une review sur ce film.');
                    header('Location: ../movie.php?id=' . $movieId);
                    exit();
                }
            }
        } else {
            \w2w\Utils\Utils::message(false, '', 'Error while saving review.');
            header('Location: ../movie.php?id=' . $movieId);
            exit();
        }

    } else {
        header("Location: homepage.php");
        exit();
    }