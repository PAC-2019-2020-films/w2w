<?php

if (checkAdmin()) {
    $reportId = param('reportId');
    $reportIsTreated = param('reportIsTreated');

    $rawInput = [
        'report' => ['num', $reportId, false],
        'isTreated' => ['num', $reportIsTreated, false]
    ];

    if (\w2w\Utils\Utils::inputValidation($rawInput)) {
        $reportDAO = new \w2w\DAO\Doctrine\DoctrineReportDAO();
        $report = $reportDAO->findOneBy('id', $reportId);
        echo "suceess";
        if ($report) {
            $report->setTreated(!$reportIsTreated);
            $result = $reportDAO->update($report);
            echo "suceess";
            \w2w\Utils\Utils::message($result, 'Plainte mise à jour', 'Echec lors de la mise à jour.');
        }
    }

}