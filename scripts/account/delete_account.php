<?php
    
    global $user;
    
//    Ensure that a user is logged in
    if (checkUser()) {
//       Get the target user id
        $userId = param('id');
        
//        Check if the target user is the same as the one currently connected
//        Users can only delete their own account : post project discussion : can an admin/root delete a user account?
        if ($user->getId() == $userId) {
        
//            Find the matching user object from the DB
            $userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();
            $userDB  = $userDAO->findOneBy('id', $user->getId());
            
//            If a user object has been found ("should" alaways be the case... but y'know...)
            if ($userDB) {

//                Find and delete every relation to the user object in the DB
//                Tokens :
                $tokenDAO = new \w2w\DAO\Doctrine\DoctrineAuthenticationTokenDAO();
                $tokens   = $tokenDAO->findBy('user', $userDB);
                foreach ($tokens as $token) {
                    $tokenDAO->delete($token);
                }

//                Reviews :
                $reviewDAO = new \w2w\DAO\Doctrine\DoctrineReviewDAO();
                $reviews   = $reviewDAO->findBy('user', $userDB);
                foreach ($reviews as $review) {
//                    If a review is an admin review : set the corresponding movie admin review to null
                    if ($review->getMovie()->getAdminReview() && $review->getMovie()->getAdminReview()->getId() === $review->getId()) {
                        $review->getMovie()->setAdminReview(null);
                    }

                    $reviewDAO->delete($review);
                }

//                Reports :
                $reportDAO = new \w2w\DAO\Doctrine\DoctrineReportDAO();
                $reports   = $reportDAO->findBy('user', $userDB);
                foreach ($reports as $report) {
                    $reportDAO->delete($report);
                }
                
//                Finally, delete the user from the DB
                $userDAO->delete($user);
                
//                Set flashbag message
                \w2w\Utils\Utils::message(true,'Compte supprimé.', '');
    
//                Log the user out
                require_once 'scripts/authentication/logout_action.php';
                
            }
        }
    }
//    Redirect to the homepage
    header("location:../homepage.php");
