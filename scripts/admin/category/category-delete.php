<?php

checkAdmin();

$id = param("id");
$confirm = param("confirm");
$context = param('context');
$deleteMovies = param('submitDeleteAllMov');
$keepMovies = param('submitHorsCat');

$categoryDAO = new \w2w\DAO\Doctrine\DoctrineCategoryDAO();
$category = $categoryDAO->findOneBy('id', $id);
$orphanCat = $categoryDAO->findOneBy('name', 'no category');



if (!$category) {
    \w2w\Utils\Utils::message(false, '', 'Catégorie non trouvé');
    if ($context == 'ajax') {
        echo "cat not found";
    } else {
        header('Location: /admin/category/category-list.php');
        exit();
    }
}

if ($orphanCat && $orphanCat->getId()== $category->getId()){
    \w2w\Utils\Utils::message(false, '', 'Cette catégorie ne peut pas etre supprimée');
    if ($context == 'ajax') {
        echo "cat not can't be deleet";
    } else {
        header('Location: /admin/category/category-list.php');
        exit();
    }
}


if ($confirm == "confirm") {

    $movieDAO = new \w2w\DAO\Doctrine\DoctrineMovieDAO();
    $movies = $movieDAO->findByCategory($category);


    if (sizeof($movies) > 0 && is_null($deleteMovies) && is_null($keepMovies)) {
        echo $category->getId();
    } else {
        if (is_null($deleteMovies) && isset($keepMovies)) {
//            Create an orphan movies category if not exist
            if (!$orphanCat) {
                $orphanCat = new \w2w\Model\Category(null, 'no category', 'no category');
                $categoryDAO->save($orphanCat);
            }
//            keep movies as uncategorized (ie $movie->setCategory($uncategorizedCat)
            foreach ($movies as $movie) {
                $movie->setCategory($orphanCat);
                $movieDAO->update($movie);
            }
        } elseif (is_null($keepMovies) && isset($deleteMovies)) {
//            Delete all the movies from the category
            foreach ($movies as $movie) {
                $movieDAO->delete($movie);
            }
        }


        $result = $categoryDAO->delete($category);
        \w2w\Utils\Utils::message($result, 'Catégorie supprimé', 'Erreur lors de la suppression de la catégorie');


        if ($context == 'ajax') {
            echo "success";
        } else {
            header('Location: /admin/category/category-list.php');
            exit();
        }
    }
}
