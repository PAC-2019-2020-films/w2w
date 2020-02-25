<?php

/**
 * script de la page d'accueil du site
 */

use \w2w\DAO\DAOFactory;


$daoFactory = DAOFactory::getDAOFactory();

$movieDAO = $daoFactory->getMovieDAO();

// Last Movies

$lastMoviesSliderNumber = 3;
$lastMoviesNumber = 12;

$lastMoviesSlider = $movieDAO->findLast($lastMoviesSliderNumber);
$lastMovies = $movieDAO->findLast($lastMoviesNumber);

// Popular

$popularMoviesNumber = 6;
$w2wPopularMoviesNumber = 5;

$popularMovies = $movieDAO->findBest($popularMoviesNumber);
$firstPopularMovie = $movieDAO->findBest(1);
$w2wPopularMovie = $movieDAO->findBest($w2wPopularMoviesNumber);

$categoryDAO = $daoFactory->getCategoryDAO();
$categories = $categoryDAO->findAll();


