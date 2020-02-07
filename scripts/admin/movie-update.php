<?php

use \w2w\DAO\DAOFactory;

checkAdmin();

$id = param("id");
$title = param("title");
$description = param("description");
$year = param("year");
$poster = param("poster");
$category_id = param("category");

$daoFactory = DAOFactory::getDAOFactory();
$movieDAO = $daoFactory->getMovieDAO();
$movie = $movieDAO->find($id);


if ($movie) {
    $movie->setTitle($title);
    $movie->setDescription($description);
    $movie->setYear($year);
    $movie->setPoster($poster);


    if (($category = $movie->getCategory()) && ($category->getId() == $category_id)) {
    } else {
        $categoryDAO = $daoFactory->getCategoryDAO();
        $category = $categoryDAO->find($category_id);
        if ($category) {
            $movie->setCategory($category);
        }
    }
    $result = $movieDAO->update($movie);

    \w2w\Utils\Utils::message($result, 'Film mis à jour', 'Erreur lors de la mise à jour du film');;
    header('Location: /admin/movie-list.php');
    exit();

//    redirect("/admin/movie-list.php", "Movie updated");
} else {
    \w2w\Utils\Utils::message(false, 'Film mis à jour', 'Erreur lors de la mise à jour du film');;
    header('Location: /admin/movie-list.php');
    exit();
//    redirect("/admin/movie-list.php", "Movie #{$id} not found");
}

