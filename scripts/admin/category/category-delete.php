<?php
//    Ensure that an admin is logged in
    if (checkAdmin()) {

//        Get the data from the category delete form
        $id           = param("id");
        $confirm      = param("confirm");
        $context      = param('context');
        $deleteMovies = param('submitDeleteAllMov');
        $keepMovies   = param('submitHorsCat');

//        TODO : input validation

//        Find the target category from the DB
        $categoryDAO = new \w2w\DAO\Doctrine\DoctrineCategoryDAO();
        $category    = $categoryDAO->findOneBy('id', $id);
//        Get the orphanCat category from the DB (the default category for "uncategorized movies")
        $orphanCat = $categoryDAO->findOneBy('name', 'no category');

//        If no matching category could be found in the DB, return error message
        if (!$category) {
            \w2w\Utils\Utils::message(false, '', 'Catégorie non trouvé');
            if ($context == 'ajax') {
                echo "cat not found";
            } else {
                header('Location: /admin/category/category-list.php');
                exit();
            }
        }

//        If the user is attempting to delete the default orphanCategory : return error message
        if ($orphanCat && $orphanCat->getId() == $category->getId()) {
            \w2w\Utils\Utils::message(false, '', 'Cette catégorie ne peut pas etre supprimée');
            if ($context == 'ajax') {
                echo "cat not can't be deleet";
            } else {
                header('Location: /admin/category/category-list.php');
                exit();
            }
        }

//        If the user has confirmed that he wishes to delete the category
        if ($confirm == "confirm") {
            
            $movieDAO = new \w2w\DAO\Doctrine\DoctrineMovieDAO();
//            Check if any movie is linked to the category
            $movies = $movieDAO->findByCategory($category);

//            If some movies are linked to the category AND the user has not chosen to either delete to movies or keep the movies as uncategorized
//            We return the category Id which can be captured in the AJAX response to prompt the user to choose between keeping or deleting the movies
//            See adminDashboard.js > Handle Category > deleteCategory(), deleteCategoryDependency()
            if (sizeof($movies) > 0 && is_null($deleteMovies) && is_null($keepMovies)) {
                echo $category->getId();
            } else {
//                If the user has chosen to keep the movies as uncategorized
                if (is_null($deleteMovies) && isset($keepMovies)) {
//                       Create and save an orphan movies category if it doesn't already exist
                    if (!$orphanCat) {
                        $orphanCat = new \w2w\Model\Category(null, 'no category', 'no category');
                        $categoryDAO->save($orphanCat);
                    }
//                      Keep movies as uncategorized (ie $movie->setCategory($orphanCat)
                    foreach ($movies as $movie) {
                        $movie->setCategory($orphanCat);
                        $movieDAO->update($movie);
                    }
                } elseif (is_null($keepMovies) && isset($deleteMovies)) {
//                      Delete all the movies from the category
                    foreach ($movies as $movie) {
                        $movieDAO->delete($movie);
                    }
                }
                
//                Finaly, delete the category form the DB
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
    }