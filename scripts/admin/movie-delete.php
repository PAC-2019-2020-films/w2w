<?php

checkAdmin();


$id = param("id");
$confirm = param("confirm");
$context = param('context');

$movieDAO = new \w2w\DAO\Doctrine\DoctrineMovieDAO();
$movie = $movieDAO->findOneBy('id', $id);


if (!$movie) {
    if ($context == 'ajax') {
        return json_encode("movie not found");
    } else {
        \w2w\Utils\Utils::message(false, '', 'Film non trouvé');
        header('Location: /admin/movie-list.php');
        exit();
    }
}

if ($confirm == "confirm") {

    $result = $movieDAO->delete($movie);
    if ($context == 'ajax') {
        return json_encode($result);
    } else {
        \w2w\Utils\Utils::message($result, 'Film supprimé', 'Erreur lors de la suppression du film');
        header('Location: /admin/movie-list.php');
        exit();
    }
}
