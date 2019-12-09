<?php

# delete or comment following line if in production env !
define("FR_ENV", "development");

require __DIR__ . "/../appsrc/bootstrap.php";


function showEntities()
{
    $entities = ["Artist", "AuthenticationToken", "Category", "Message", "Movie", "Rating", "Report", "Review", "Role", "Tag", "User"];
    $tot = count($entities);
    $cpt = 0;
    foreach ($entities as $entity) {
        $daoClassName = "w2w\\DAO\\Doctrine\\Doctrine{$entity}DAO";
        $dao = new $daoClassName;
        echo sprintf("Entity %d/%d : %s\n", ++$cpt, $tot, $entity);
        foreach ($dao->findAll() as $item) {
            echo sprintf("\t- %s\n", (string) $item);
        }
    }
    echo "\n";
}


function showMovie($title)
{
    $dao = new \w2w\DAO\Doctrine\DoctrineMovieDAO();
    $movie = $dao->findByTitle($title);
    if ($movie) {
        echo "$movie\n";
        foreach ($movie->getDirectors() as $artist) {
            echo "\t- director : $artist\n";
        }
        foreach ($movie->getActors() as $artist) {
            echo "\t- actor : $artist\n";
        }
    } else {
        echo "movie not found (title='$title')\n";
    }
    echo "\n";
}

showEntities();
showMovie("Unforgiven");
showMovie("Million Dollar Baby");
showMovie("La Promesse");
