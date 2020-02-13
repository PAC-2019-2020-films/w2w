<?php

$movieDAO = new \w2w\DAO\Doctrine\DoctrineMovieDAO();

//Default page = 1
$page = 1;

//Obtenir la page actuelle
if (param('page')) {
    $page = param('page');
}

//Définir le nombre de film par page
$limit = 5;

//Obtenir les films de la page demandée
$movies = $movieDAO->getAllMovies($page, $limit);

$maxPages = ceil($movies->count() / $limit);
$prevPage = $page-1;
$nextPage = $page+1;


