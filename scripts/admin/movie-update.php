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


$flashManager = new \w2w\Utils\FlashManager();

$daoFactory = DAOFactory::getDAOFactory();
$movieDAO = $daoFactory->getMovieDAO();
$movie = $movieDAO->find($id);



if (! $movie instanceof Movie) {
    redirectWarning("/admin/movie-list.php", "Film non trouvé.");
}

$failure = false;

if (! $title) {
    $failure = true;
    $flashManager->error("Veuillez fournir un titre.");
} elseif ($title != $movie->getTitle()) {
    $other = $movieDAO->findByTitle($title);
    if ($other instanceof Movie && $other->getId() != $movie->getId()) {
        $failure = true;
        $flashManager->error("Ce titre est indiponible. Veuillez en fournir un autre.");
    }
}





if (! preg_match("#^[0-9]{4}$#", $year)) {
    $failure = true;
    $flashManager->error("Veuillez fournir une date correcte (YYYY).");
}

if (! $failure) {

    $movie->setTitle($title);
    $movie->setDescription($description);
    $movie->setYear($year);
    $movie->setPoster($poster);

    # category :
    
    if (($category = $movie->getCategory()) && ($category->getId() == $category_id)) {
        # si la catégorie actuelle correspond à l'id de category du formulaire, rien n'a changé
    } else {
        # sinon, on recharge une autre category
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
    
}



    # uplaod du poster si fichier envoyé :
    # (annulation de l'opération en cas d'échec)
    $notification = new \w2w\Utils\Notification();
    $posterUploader = new \w2w\Utils\PosterUploader();
    if ($posterUploader->hasUpload()) {
        try {
            $validateOnly = $failure;
            $uploaded = $posterUploader->upload($movie, $notification, $validateOnly);
            if ($notification->hasErrors()) {
                foreach ($notification->getErrors() as $error) {
                    $failure = true;
                    $flashManager->error($error);
                }
            } elseif (! $uploaded) {
                $failure = true;
                $flashManager->warning("L'affiche n'a pas été uploadée.");
            }
        } catch (\Exception $e) {
            $failure = true;
            $flashManager->warning("Erreur lors de l'upload de l'image (dbg:{$e->getMessage()}).");
        }
    }


    
if (! $failure) {
    try {
        $result = $movieDAO->update($movie);
    } catch (\Exception $e) {
        $failure = true;
        $flashManager->warning("Erreur lors de la mise à jour du film.({$e->getMessage()}).");
    }
    
}


    


if (! $failure) {
    # succès de l'opération :
    redirectSuccess('/admin/', 'Film mis à jour');
} else {
    # échec de l'opération :
    # réaffichage du formulaire avec les valeurs entrées par l'utilisateur
    
    $categoryDAO = $daoFactory->getCategoryDAO();
    $categories = $categoryDAO->findAll();
    $tagDAO = $daoFactory->getTagDAO();
    $tags = $tagDAO->findAll();
    $artistDAO = $daoFactory->getArtistDAO();
    $artists = $artistDAO->findAll();
    
    echo template("admin/form.movie.php", [
        "action" =>"/admin/movie-update.php",
        "id" => $id,
        "categories" => $categories,
        "tags" => $tags,
        "artists" => $artists,
        "title" => $title,
        "description" => $description,
        "year" => $year,
        "poster" => $poster,
        "categories" => $categories,
        "category_id" => $category_id,
        "tags" => $tags,
        "tags_selected_ids" => $tag_ids,
        "artists" => $artists,
        "directors_selected_ids" => $director_ids,
        "actors_selected_ids" => $actor_ids,
    ]);
}
