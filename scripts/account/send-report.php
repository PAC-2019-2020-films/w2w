<?php
//    Ensure that a user is connected
    global $user;
    checkUser();
    
//    Get the report data from the submitted form
    $reportMessage = param("reportContent");
    $reviewId      = param("id");
    $movieId = param('movieId');
    
//    Input validation
    $rawInput = [
        'message' => ['alphanum', $reportMessage, false],
        'id'      => ['num', $reviewId, false],
        'movieId' => ['num', $movieId, false]
    ];
    
    if (\w2w\Utils\Utils::inputValidation($rawInput)) {
    
//        Set the createdAt time as NOW
        $createdAt = new DateTime("now", new DateTimeZone("Europe/Brussels"));
        
//        Find the target review of the report
        $reviewDAO = new \w2w\DAO\Doctrine\DoctrineReviewDAO();
        $review = $reviewDAO->findOneBy('id', $reviewId);
        
//        Create a new report object from the form data, then save the report in the DB
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
    