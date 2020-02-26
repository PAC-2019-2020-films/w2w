<?php
    
    global $user;
    
    if (checkUser()) {
       
        $userId = param('id');
       
        if ($user->getId() == $userId) {
            
            $userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();
            $userDB  = $userDAO->findOneBy('id', $user->getId());
            if ($userDB) {

                $tokenDAO = new \w2w\DAO\Doctrine\DoctrineAuthenticationTokenDAO();
                $tokens   = $tokenDAO->findBy('user', $userDB);
                foreach ($tokens as $token) {
                    $tokenDAO->delete($token);
                }

                $reviewDAO = new \w2w\DAO\Doctrine\DoctrineReviewDAO();
                $reviews   = $reviewDAO->findBy('user', $userDB);
                foreach ($reviews as $review) {
                    if ($review->getMovie()->getAdminReview() && $review->getMovie()->getAdminReview()->getId() === $review->getId()) {
                        $review->getMovie()->setAdminReview(null);
                    }

                    $reviewDAO->delete($review);
                }

                $reportDAO = new \w2w\DAO\Doctrine\DoctrineReportDAO();
                $reports   = $reportDAO->findBy('user', $userDB);
                foreach ($reports as $report) {
                    $reportDAO->delete($report);
                }
                
                $userDAO->delete($user);
                
                \w2w\Utils\Utils::message(true,'Compte supprimé.', '');
    
                require_once 'scripts/authentication/logout_action.php';
                
            }
        }
    }
    
    header("location:../homepage.php");
