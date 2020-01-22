<?php

/**
 * script de la page d'accueil du site
 */

use \w2w\DAO\DAOFactory;


$lastMoviesSliderNumber = 3;
$lastMoviesNumber = 6;

$popularMoviesNumber = 10;

$w2wPopularMoviesNumber = 5;


$daoFactory = DAOFactory::getDAOFactory();

$movieDAO = $daoFactory->getMovieDAO();

// Last Movies

$lastMoviesSlider = $movieDAO->findLast($lastMoviesSliderNumber);
$lastMovies = $movieDAO->findLast($lastMoviesNumber);

// Popular
$popularMovies = $movieDAO->findBest($popularMoviesNumber);
$firstPopularMovie = $movieDAO->findBest(1);
$w2wPopularMovie = $movieDAO->findBest($w2wPopularMoviesNumber);

$categoryDAO = $daoFactory->getCategoryDAO();
$categories = $categoryDAO->findAll();


