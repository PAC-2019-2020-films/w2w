<?php

checkAdmin();


$id = param("id");
$confirm = param("confirm");
$context = param('context');

$movieDAO = new \w2w\DAO\Doctrine\DoctrineMovieDAO();
$movie = $movieDAO->findOneBy('id', $id);


if (!$movie) {
    \w2w\Utils\Utils::message(false, '', 'Film non trouvé');

    if ($context == 'ajax') {
        return json_encode("movie not found");
    } else {
        header('Location: /admin/movie/');
        exit();
    }
}

if ($confirm == "confirm") {

    $result = $movieDAO->delete($movie);
    \w2w\Utils\Utils::message($result, 'Film supprimé', 'Erreur lors de la suppression du film');

    if ($context == 'ajax') {
        return json_encode($result);
    } else {
        header('Location: /admin/movie/');
        exit();
    }
}
