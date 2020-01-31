<?php

global $user;

$reviewDAO = new \w2w\DAO\Doctrine\DoctrineReviewDAO();
$userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();

if ($user) {
    $reviewId = param("id");
    $rawInput = [
        'reviewId' => ['num', $reviewId, false]
    ];

    if (\w2w\Utils\Utils::inputValidation($rawInput)) {
        $review = $reviewDAO->findOneBy('id', $reviewId);

        if ($user->getId() === $review->getUser()->getId()) {
            $reviewDAO->delete($review);
            \w2w\Utils\Utils::message(true, 'Critique Supprimée', '');
            header('Location: ../movie.php?id=' . $review->getMovie()->getId());
        }
    }
}