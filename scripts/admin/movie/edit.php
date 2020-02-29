<?php
use \w2w\DAO\DAOFactory;

checkAdmin();

$id = param("id");
$daoFactory = DAOFactory::getDAOFactory();
$categoryDAO = $daoFactory->getCategoryDAO();
$categories = $categoryDAO->findAll();
$tagDAO = $daoFactory->getTagDAO();
$tags = $tagDAO->findAll();
$artistDAO = $daoFactory->getArtistDAO();
$artists = $artistDAO->findAll();
$movieDAO = $daoFactory->getMovieDAO();
$movie = $movieDAO->find($id);

if (! $movie) {
    redirectWarning("/admin/movie/", "Film non trouvé.");
}

if ($category = $movie->getCategory()) {
    $category_id = $category->getId();
} else {
    $category_id = null;
}

# prépare liste des tags préslectionnés pour le select :
$tags_selected_ids = [];
foreach ($movie->getTags() as $tag) {
    $tags_selected_ids[] = $tag->getId();
}

# prépare liste des directors préslectionnés pour le select :
$directors_selected_ids = [];
foreach ($movie->getDirectors() as $director) {
    $directors_selected_ids[] = $director->getId();
}

# prépare liste des actors préslectionnés pour le select :
$actors_selected_ids = [];
foreach ($movie->getActors() as $actor) {
    $actors_selected_ids[] = $actor->getId();
}

echo template("admin/form.movie.php", [
    "action" =>"/admin/movie/update.php",
    "id" => $movie->getId(),
    "title" => $movie->getTitle(),
    "description" => $movie->getDescription(),
    "year" => $movie->getYear(),
    "poster" => $movie->getPoster(),
    "categories" => $categories,
    "category_id" => $category_id,
    "tags" => $tags,
    "tags_selected_ids" => $tags_selected_ids,
    "artists" => $artists,
    "directors_selected_ids" => $directors_selected_ids,
    "actors_selected_ids" => $actors_selected_ids,
]);
