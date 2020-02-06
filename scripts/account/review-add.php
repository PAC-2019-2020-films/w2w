<?php
    global $user;
    
    if (checkUser()) {
    
//        \w2w\Utils\Utils::dump($_POST['comment']);
//        die();
        
        $movieId  = param('movieId');
        $comment  = param('comment');
        $ratingId = param("rating");
    
//        \w2w\Utils\Utils::dump($comment);
//        die();
        
        $rawInput = [
            'movie'   => ["num", $movieId, false],
            'comment' => ['ckedit', $comment, false],
            'rating'  => ['num', $ratingId, false]
        ];
        
        if (\w2w\Utils\Utils::inputValidation($rawInput)) {
            
            $reviewDAO = new \w2w\DAO\Doctrine\DoctrineReviewDAO();
            $movieDAO  = new \w2w\DAO\Doctrine\DoctrineMovieDAO();
            $ratingDAO = new \w2w\DAO\Doctrine\DoctrineRatingDAO();
            
            $movie     = $movieDAO->findOneBy('id', $movieId);
            $createdAt = new DateTime("now", new DateTimeZone("Europe/Brussels"));
            $rating    = $ratingDAO->findOneBy('id', $ratingId);
          
            
            if (isset($movie) && isset($rating)) {
                if (!($reviewDAO->findByUserAndMovie($user, $movie))) {
                    $review = new \w2w\Model\Review(1, $comment, $createdAt, null, $movie, $user, $rating);
                    $reviewDAO->save($review);
//                TODO : check unique review for user/movie association
                    
                    \w2w\Utils\Utils::message(true, "Votre review a été postée!", "");
                    header('Location: ../movie.php?id=' . $movieId);
                } else {
                    \w2w\Utils\Utils::message(false, '', 'Vous avez déjà publié une review sur ce film.');
                    header('Location: ../movie.php?id=' . $movieId);
                }
            }
        } else {
            \w2w\Utils\Utils::message(false, '', 'Error while saving review.');
            header('Location: ../movie.php?id=' . $movieId);
        }
        
        
    } else {
        header("Location: homepage.php");
    }