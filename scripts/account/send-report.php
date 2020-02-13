<?php
    global $user;
    checkUser();
    
    $reportMessage = param("reportContent");
    $reviewId      = param("id");
    $movieId = param('movieId');
    
    $rawInput = [
        'message' => ['alphanum', $reportMessage, false],
        'id'      => ['num', $reviewId, false],
        'movieId' => ['num', $movieId, false]
    ];
    
    if (\w2w\Utils\Utils::inputValidation($rawInput)) {
        
        $createdAt = new DateTime("now", new DateTimeZone("Europe/Brussels"));
        
        $reviewDAO = new \w2w\DAO\Doctrine\DoctrineReviewDAO();
        $review = $reviewDAO->findOneBy('id', $reviewId);
        
        
        $reportDAO = new \w2w\DAO\Doctrine\DoctrineReportDAO();
        $report    = new \w2w\Model\Report(null, $reportMessage, $createdAt, false, $user, $review);
        
        $reportDAO->save($report);
        
        \w2w\Utils\Utils::message(true, "Rapport envoyé", "");
        header("Location: ../movie.php?id=".$movieId);
        exit();
        
    } else {
        \w2w\Utils\Utils::message(false, "", 'Champ invalide.');
        header("Location: ../movie.php?id=".$movieId);
    exit();
    }
    