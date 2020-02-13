<?php

checkAdmin();


$id = param("id");
$confirm = param("confirm");
$context = param('context');


$categoryDAO = new \w2w\DAO\Doctrine\DoctrineCategoryDAO();
$category = $categoryDAO->findOneBy('id', $id);


if (!$category) {
    if ($context == 'ajax') {
        return json_encode("cat not found");
    } else {
        \w2w\Utils\Utils::message(false, '', 'Catégorie non trouvé');
        header('Location: /admin/category/category-list.php');
        exit();
    }
}

if ($confirm == "confirm") {

    /*
    * TODO : CHECK POTENTIAL ORPHAN MOVIE & WARN USER
    */


    $result = $categoryDAO->delete($category);
    if ($context == 'ajax') {
        return json_encode($result);
    } else {
        \w2w\Utils\Utils::message($result, 'Catégorie supprimé', 'Erreur lors de la suppression de la catégorie');
        header('Location: /admin/category/category-list.php');
        exit();
    }
}
