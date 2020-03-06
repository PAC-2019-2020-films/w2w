<?php
//    Ensure that a user is logged in
    global $user;
    if (checkUser()) {
    
//        Get the review data from the submitted form
        $movieId = param('movieId');
        $reviewId = param('reviewId');
        $content  = param('comment');
        $ratingId = param('rating');
        
//        Input validation
        $rawInput = [
            'movieId' => ['num', $movieId, false],
            'reviewId' => ["num", $reviewId, false],
            'comment'  => ['ckedit', $content, false],
            'rating'   => ['num', $ratingId, false]
        ];


        if (\w2w\Utils\Utils::inputValidation($rawInput)) {

            $reviewDAO = new \w2w\DAO\Doctrine\DoctrineReviewDAO();
            $ratingDAO = new \w2w\DAO\Doctrine\DoctrineRatingDAO();
            
//            Find the matching review and rating objects form the DB
            $review = $reviewDAO->findOneBy('id', $reviewId);
            $rating = $ratingDAO->findOneBy('id', $ratingId);
            $updatedAt = $createdAt = new DateTime("now", new DateTimeZone('Europe/Brussels'));

//            Update the review content, rating and updatedAt and update the review object in the DB
            $review->setContent($content);
            $review->setUpdatedAt($updatedAt);
            $review->setRating($rating);
            
            $reviewDAO->update($review);
    
            \w2w\Utils\Utils::message(true, 'Votre critique a bien été éditée.', '');
            header('Location: ../movie.php?id=' . $movieId);
            
        } else {
            \w2w\Utils\Utils::message(false, '', 'Error while saving review.');
            header('Location: ../movie.php?id=' . $movieId);
        }
        
    } else {
        header("Location: homepage.php");
        
    }