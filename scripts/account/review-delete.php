<?php
    
    global $user;
    
    $reviewDAO = new \w2w\DAO\Doctrine\DoctrineReviewDAO();
    $userDAO   = new \w2w\DAO\Doctrine\DoctrineUserDAO();
    
    if ($user) {
        $reviewId = param("id");
        $context  = param("context");
        $rawInput = [
            'reviewId' => ['num', $reviewId, false]
        ];
        
        
        if (\w2w\Utils\Utils::inputValidation($rawInput)) {
            $review = $reviewDAO->findOneBy('id', $reviewId);

//        If the user is the one who poster the review OR if the user has higher role than the one who posted the review
            if ($user->getId() === $review->getUser()->getId() || $review->getUser()->getRole()->getId() < $user->getRole()->getId()) {
//                If the user is admin or root : check if the review is an admin review
                if ($user->isAdmin() || $user->isRoot()) {
                    
                    $movieDAO = new \w2w\DAO\Doctrine\DoctrineMovieDAO();
                    $movie    = $movieDAO->findOneBy('adminReview', $review);
                    
                    if ($movie && $movie->getAdminReview()->getId() == $reviewId) {
                        $movie->setAdminReview(null);
                        $movieDAO->update($movie);
                    }
                }

//                Find the owner of the review to update the review count
                if ($user->getId() === $review->getUser()->getId()) {
                    $reviewUser = $user;
                } else {
                    $reviewUser = $review->getUser();
                }

//                Check if a report is linked to the review and delete it
                $reportDAO = new \w2w\DAO\Doctrine\DoctrineReportDAO();
                $reports   = $reportDAO->findBy('review', $review);
                
                foreach ($reports as $report) {
                    $reportDAO->delete($report);
                }

//                Delete the review and update the user's review count
                $reviewDAO->delete($review);
                $reviewUser->setNumberReviews($reviewUser->getNumberReviews() - 1);
                $userDAO->update($reviewUser);
                
                \w2w\Utils\Utils::message(true, 'Critique Supprimée', '');
                
                if ($context == "ajax") {
                    echo true;
                } else {
                    header('Location: ../movie.php?id=' . $review->getMovie()->getId());
                    exit();
                }
            }
        }
    }