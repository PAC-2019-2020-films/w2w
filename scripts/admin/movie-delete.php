<?php
use \w2w\DAO\DAOFactory;

checkAdmin();

$id = param("id");
$confirm = param("confirm");

$daoFactory = DAOFactory::getDAOFactory();
$movieDAO = $daoFactory->getMovieDAO();
$movie = $movieDAO->find($id);

if (! $movie) {
    \w2w\Utils\Utils::message(false, '', 'Film non trouvé');
    header('Location: /admin/movie-list.php');
    exit();
//    redirect("/admin/movie-list.php", "Movie #{$id} not found");
}

if ($confirm == "confirm") {
    $result = $movieDAO->delete($movie);
    \w2w\Utils\Utils::message($result, 'Film supprimé', 'Erreur lors de la suppression du film');
    header('Location: /admin/movie-list.php');
    exit();
//    redirect("/admin/movie-list.php", "Film supprimé.");
}

