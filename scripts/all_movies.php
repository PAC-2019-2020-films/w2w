<?php
    
    $movieDAO = new \w2w\DAO\Doctrine\DoctrineMovieDAO();
    $movies = $movieDAO->findAll();