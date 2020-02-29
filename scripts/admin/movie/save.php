<?php
use \w2w\DAO\DAOFactory;
use \w2w\Model\Category;
use \w2w\Model\Movie;
use \w2w\Utils\FlashManager;
use \w2w\Utils\Notification;
use \w2w\Utils\PosterManager;

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

$flashManager = new FlashManager();

$savingFailed = false;


# vérifications sur le titre :
if (! $title) {
    $savingFailed = true;
    $flashManager->error("Veuillez fournir un titre.");
} else {
    $other = $movieDAO->findByTitle($title);
    if ($other instanceof Movie) {
        $savingFailed = true;
        $flashManager->error("Ce titre est indiponible. Veuillez en fournir un autre.");
    }
}

# vérifications sur l'année :
if (($year != null) && (! preg_match("#^[0-9]{4}$#", $year))) {
    $savingFailed = true;
    $flashManager->error("Veuillez fournir une date correcte (YYYY).");
}


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

# instanciation nouvel objet Movie :
if ($year != null) {
    $year = (int) $year;
} else {
    $year = null;
}
$movie = new Movie(null, $title, $description, $year, $poster, $category);

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

# saving movie :
 
if (! $savingFailed) {
    try {
        $movieDAO->save($movie);
        if (! $movie->getId() > 0) {
            $savingFailed = true;
            $flashManager->warning("Échec lors de l'ajout du film.");
        }
    } catch (\Exception $e) {
        if (FR_DEBUG) {
            throw $e;
        } else {
            $savingFailed = true;
            $flashManager->warning("Échec lors de l'ajout du film.");
        }
    }
}    


# upload des affiches  :

if (! $savingFailed) {
    $notification = new Notification();
    $posterManager = new PosterManager();
    try {
        $uploaded = $posterManager->upload($movie, $notification);
        foreach ($notification->getWarnings() as $warning) {
            $flashManager->warning($warning);
        }
        foreach ($notification->getErrors() as $error) {
            $flashManager->error($error);
        }
    } catch (\Exception $e) {
        if (FR_DEBUG) {
            throw $e;
        } else {
            $flashManager->warning("Erreur lors de l'upload.");
        }
    }
}
    
    
    


if (! $savingFailed) {
    # succès de l'opération :
    redirectSuccess("/admin/movie/show.php?id=" . $movie->getId(), "Film ajouté.");
} else {
    # échec de l'opération :
    # réaffichage du formulaire avec les valeurs entrées par l'utilisateur
    
    $categories = $categoryDAO->findAll();
    $tagDAO = $daoFactory->getTagDAO();
    $tags = $tagDAO->findAll();
    $artistDAO = $daoFactory->getArtistDAO();
    $artists = $artistDAO->findAll();

    echo template("admin/form.movie.php", [
        "action" =>"/admin/movie/save.php",
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
