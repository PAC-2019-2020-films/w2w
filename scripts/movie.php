<?php
    
    use \w2w\DAO\DAOFactory;
    
    global $user;
    
    $id = param("id");
    
    $daoFactory = DAOFactory::getDAOFactory();
    $movieDAO   = $daoFactory->getMovieDAO();
    $movie      = $movieDAO->find($id);
    $ratingDAO  = new \w2w\DAO\Doctrine\DoctrineRatingDAO();
    $ratings    = $ratingDAO->findAll();
    
    
    if (isset($user)) {
        $reviewDAO          = new \w2w\DAO\Doctrine\DoctrineReviewDAO();
        $hasAlreadyReviewed = $reviewDAO->findByUserAndMovie($user, $movie);
    }else{
        $hasAlreadyReviewed = false;
    }
    //\w2w\Utils\Utils::dump($hasAlreadyReview);
    //die();

