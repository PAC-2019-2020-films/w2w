<?php

use \w2w\DAO\DAOFactory;

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
$movie = $movieDAO->find($id);


if ($movie) {
    $movie->setTitle($title);
    $movie->setDescription($description);
    $movie->setYear($year);
    $movie->setPoster($poster);

    # category :
    
    if (($category = $movie->getCategory()) && ($category->getId() == $category_id)) {
    } else {
        $categoryDAO = $daoFactory->getCategoryDAO();
        $category = $categoryDAO->find($category_id);
        if ($category) {
            $movie->setCategory($category);
        }
    }

    # tags :
    
    if (! is_array($tag_ids)) {
        $tag_ids = [];
    }
    foreach ($movie->getTags() as $tag) {
        if (! in_array($tag->getId(), $tag_ids)) {
            $movie->removeTag($tag);
        }
    }
    $tagDAO = $daoFactory->getTagDAO();
    foreach ($tag_ids as $id) {
        if ($tag = $tagDAO->find($id)) {
            if (! $movie->hasTag($tag)) {
                $movie->addTag($tag);
            }
        }
    }
    
    # directors :
    
    if (! is_array($director_ids)) {
        $director_ids = [];
    }
    foreach ($movie->getDirectors() as $artist) {
        if (! in_array($artist->getId(), $director_ids)) {
            $movie->removeDirector($artist);
        }
    }
    $artistDAO = $daoFactory->getArtistDAO();
    foreach ($director_ids as $id) {
        if ($artist = $artistDAO->find($id)) {
            if (! $movie->hasDirector($artist)) {
                $movie->addDirector($artist);
            }
        }
    }
    
    # actors :
    
    if (! is_array($actor_ids)) {
        $actor_ids = [];
    }
    foreach ($movie->getActors() as $artist) {
        if (! in_array($artist->getId(), $actor_ids)) {
            $movie->removeActor($artist);
        }
    }
    foreach ($actor_ids as $id) {
        if ($artist = $artistDAO->find($id)) {
            if (! $movie->hasActor($artist)) {
                $movie->addActor($artist);
            }
        }
    }
    
    $result = $movieDAO->update($movie);

    redirect($result, 'Film mis à jour', 'Erreur lors de la mise à jour du film', '/admin/');
    //redirect("/admin/movie-list.php", "Movie updated");
} else {
    redirectWarning('/admin/', 'Erreur lors de la mise à jour du film');
    //redirect("/admin/movie-list.php", "Movie #{$id} not found");
}

