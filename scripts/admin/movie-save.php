<?php
use \w2w\DAO\DAOFactory;
use \w2w\Model\Movie;

checkAdmin();

$id = param("id");
$title = param("title");
$description = param("description");
$year = param("year");
$poster = param("poster");
$category_id = param("category");

$daoFactory = DAOFactory::getDAOFactory();
$movieDAO = $daoFactory->getMovieDAO();
$categoryDAO = $daoFactory->getCategoryDAO();
$category = $categoryDAO->find($category_id);

$movie = new Movie(null, $title, $description, (int) $year, $poster, $category);
$movieDAO->save($movie);

if ($movie->getId() > 0) {
    redirect("/admin/movie-list.php", "Film ajouté ({$movie->getid()})");
} else {
    redirect("/admin/movie-list.php", "Échec lors de l'ajout.");
}

