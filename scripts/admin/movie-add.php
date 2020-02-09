<?php
use \w2w\DAO\DAOFactory;

checkAdmin();



$daoFactory = DAOFactory::getDAOFactory();
$categoryDAO = $daoFactory->getCategoryDAO();
$categories = $categoryDAO->findAll();
$tagDAO = $daoFactory->getTagDAO();
$tags = $tagDAO->findAll();
$artistDAO = $daoFactory->getArtistDAO();
$artists = $artistDAO->findAll();



echo template("admin/form.movie.php", [
    "action" =>"/admin/movie-save.php",
    "categories" => $categories,
    "tags" => $tags,
    "artists" => $artists,
    /*"id" => $movie->getId(),
    "title" => $movie->getTitle(),
    "description" => $movie->getDescription(),
    "year" => $movie->getYear(),
    "poster" => $movie->getPoster(),*/
]);
