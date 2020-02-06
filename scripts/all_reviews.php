<?php

$reviewsDAO = new \w2w\DAO\Doctrine\DoctrineReviewDAO();

$reviews = $reviewsDAO->findAll();