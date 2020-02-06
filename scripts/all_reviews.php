<?php

$moviesDAO = new \w2w\DAO\Doctrine\DoctrineMovieDAO();

$movies = $moviesDAO->findAll();