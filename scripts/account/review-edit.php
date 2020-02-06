<?php
    global $user;
    
    
    if (checkUser()) {
        $movieId = param('movieId');
        $reviewId = param('reviewId');
        $content  = param('comment');
        $ratingId = param('rating');
        
        $rawInput = [
            'movieId' => ['num', $movieId, false],
            'reviewId' => ["num", $reviewId, false],
            'comment'  => ['ckedit', $content, false],
            'rating'   => ['num', $ratingId, false]
        ];
        
        if (\w2w\Utils\Utils::inputValidation($rawInput)) {
            $reviewDAO = new \w2w\DAO\Doctrine\DoctrineReviewDAO();
            $ratingDAO = new \w2w\DAO\Doctrine\DoctrineRatingDAO();
            
            $review = $reviewDAO->findOneBy('id', $reviewId);
            $rating = $ratingDAO->findOneBy('id', $ratingId);

            $review->setContent($content);
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