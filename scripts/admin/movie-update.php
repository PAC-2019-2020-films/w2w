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
    $movieDAO->update($movie);
    redirect("/admin/movie-list.php", "Movie updated");
} else {
    redirect("/admin/movie-list.php", "Movie #{$id} not found");
}

