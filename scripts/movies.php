<?php

/**
 * Recherche paginées de films, par mot-clé, catégorie, tag, rating ou année.
 * 
 * - pour le moment, les critères de recherche sont mutuellement exclusifs
 * - ce script peut remplacer all_movies.php (si pas de paramètre de recherche fourni, 
 *   on renvoie tous les films alphabétiquement, comme all_movies.php).
 * 
 */
$daoFactory = \w2w\DAO\DAOFactory::getDAOFactory();
$movieDAO = $daoFactory->getMovieDAO();

//Default page = 1
$pageDefault = 1;
//Définir le nombre de film par page
$limitDefault = 5;
$limitMax = 10;

$page = (int) param('page', $pageDefault);
$limit = (int)  param('limit'); //, $limitDefault);
$keywords = param("keywords");
$category = param("category");
$tag = param("tag");
$rating = param("rating");
$year = param("year");


if ($page <= 0) {
    $page = $pageDefault;
}
if ($limit <= 0) {
    $limit = $limitDefault;
}
if ($limit > $limitMax) {
    $limit = $limitMax;
}

//recupere la page active
if(isset($_GET['page'])) {
    $pageActive = htmlentities($_GET['page']);
}

$baseUrl = "/movies.php?";
$firstParameter = true;
foreach (["keywords", "category", "tag", "rating", "year"] as $parameter) {
    if (${$parameter}) {
        if ($firstParameter) {
            $baseUrl .= $parameter . "=" . ${$parameter};
            $firstParameter = false;
        } else {
            $baseUrl .= "&amp;" . $parameter . "=" . ${$parameter};
        }
    }
}

//Obtenir les films de la page demandée
$movies = $movieDAO->search($keywords, $category, $tag, $rating, $year, $page, $limit);
$nombreFilm = $movies->count();
$maxPages = ceil($nombreFilm / $limit);
$prevPage = $page-1;
$nextPage = $page+1;

//Obtenir la liste des catégories
$categoryDAO = new \w2w\DAO\Doctrine\DoctrineCategoryDAO();
$categories  = $categoryDAO->findAll();

//Obtenir la liste des tags
$tagDAO = new \w2w\DAO\Doctrine\DoctrineTagDAO();
$tags  = $tagDAO->findAll();

//Obtenir la liste des Notes
$ratingsDAO = new \w2w\DAO\Doctrine\DoctrineRatingDAO();
$ratings  = $ratingsDAO->findAll();
