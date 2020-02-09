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
$tag_ids = param("tags");
$director_ids = param("directors");
$actor_ids = param("actors");


$daoFactory = DAOFactory::getDAOFactory();
$movieDAO = $daoFactory->getMovieDAO();
$categoryDAO = $daoFactory->getCategoryDAO();
$category = $categoryDAO->find($category_id);

$movie = new Movie(null, $title, $description, (int) $year, $poster, $category);




    # tags :
    
    if (! is_array($tag_ids)) {
        $tag_ids = [];
    }
    $tagDAO = $daoFactory->getTagDAO();
    foreach ($tag_ids as $id) {
        if ($tag = $tagDAO->find($id)) {
            $movie->addTag($tag);
        }
    }
    
    # directors :
    
    if (! is_array($director_ids)) {
        $director_ids = [];
    }
    $artistDAO = $daoFactory->getArtistDAO();
    foreach ($director_ids as $id) {
        if ($artist = $artistDAO->find($id)) {
            $movie->addDirector($artist);
        }
    }
    
    # actors :
    
    if (! is_array($actor_ids)) {
        $actor_ids = [];
    }
    foreach ($actor_ids as $id) {
        if ($artist = $artistDAO->find($id)) {
            $movie->addActor($artist);
        }
    }




$movieDAO->save($movie);

if ($movie->getId() > 0) {
    redirectSuccess("/admin/", "Film ajouté ({$movie->getId()})");
} else {
    redirectWarning("/admin/", "Échec lors de l'ajout.");
}
