<?php
use \w2w\DAO\DAOFactory;
use \w2w\Model\Category;
use \w2w\Model\Movie;

checkAdmin();

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


$flashManager = new \w2w\Utils\FlashManager();


$savingFailed = false;

# récupération de la catégorie :
# (annulation de l'opération en cas d'échec)
if ($category_id) {
    $category = $categoryDAO->find($category_id);
    if (! $category instanceof Category) {
        $savingFailed = true;
        $flashManager->error("Catégorie non trouvée.");
    }
} else {
    $category = null;
    $savingFailed = true;
    $flashManager->error("Veuillez choisir une catégorie.");
}


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



    # uplaod du poster si fichier envoyé :
    # (annulation de l'opération en cas d'échec)
    $notification = new \w2w\Utils\Notification();
    $posterUploader = new \w2w\Utils\PosterUploader();
    if ($posterUploader->hasUpload()) {
        try {
            $validateOnly = $savingFailed;
            $uploaded = $posterUploader->upload($movie, $notification, $validateOnly);
            if ($notification->hasErrors()) {
                foreach ($notification->getErrors() as $error) {
                    $savingFailed = true;
                    $flashManager->error($error);
                }
            } elseif (! $uploaded) {
                $savingFailed = true;
                $flashManager->warning("L'affiche n'a pas été uploadée.");
            }
        } catch (\Exception $e) {
            $savingFailed = true;
            $flashManager->warning("Erreur lors de l'upload de l'image (dbg:{$e->getMessage()}).");
        }
    }

 
if (! $savingFailed) {
    # saving movie :

    if (! $savingFailed) {
        try {
            $movieDAO->save($movie);
            if (! $movie->getId() > 0) {
                $savingFailed = true;
                $flashManager->warning("Échec lors de l'ajout du film.");
            }
        } catch (\Exception $e) {
            $savingFailed = true;
            if (FR_DEBUG) {
                throw $e;
            } else {
                $flashManager->warning("Erreur lors de l'ajout du film.({$e->getMessage()}).");
            }
        }
    }

}    
    
    


if (! $savingFailed) {
    # succès de l'opération :
    redirectSuccess("/admin/", "Film ajouté.");
} else {
    # échec de l'opération :
    # réaffichage du formulaire avec les valeurs entrées par l'utilisateur
    
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
    //redirectWarning("/admin/", "Échec lors de l'ajout.");
}
