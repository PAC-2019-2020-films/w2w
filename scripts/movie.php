<?php

use \w2w\DAO\DAOFactory;

global $user;

$id = param("id");

$daoFactory = DAOFactory::getDAOFactory();
$movieDAO = $daoFactory->getMovieDAO();
$movie = $movieDAO->find($id);
$ratingDAO = new \w2w\DAO\Doctrine\DoctrineRatingDAO();
$ratings = $ratingDAO->findAll();

$adminReview = $movie->getAdminReview();


// Calcul avis utilisateur moyen
$reviews = $movie->getReviews();
$ratingCount = 0;
$totalRating = 0;

foreach ($reviews as $review) {
    if (!$review->getUser()->isAdmin()) {
        $totalRating += $review->getRating()->getValue();
        $ratingCount++;
    }
}

if ($ratingCount > 0) {
    $averageRating = ceil($totalRating / $ratingCount);
    $averageUserRating = $ratingDAO->findOneBy('value', $averageRating);
} else {
    $averageUserRating = false;
}


if (isset($user)) {
    $reviewDAO = new \w2w\DAO\Doctrine\DoctrineReviewDAO();
    $hasAlreadyReviewed = $reviewDAO->findByUserAndMovie($user, $movie);
} else {
    $hasAlreadyReviewed = false;
}

