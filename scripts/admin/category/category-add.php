<?php
//    Ensure that an admin is logged in
    if (checkAdmin()) {

//        Get the category data from the submitted form
        $name        = param("nameCat");
        $description = param("description");

//        Input validation
        $rawInput = [
            'name' => ['alpha', $name, false],
            'desc' => ['alpha', $description, false]
        ];
        
        if (\w2w\Utils\Utils::inputValidation($rawInput)) {

//            Create a new category object from the form data
            $categoryDAO = new \w2w\DAO\Doctrine\DoctrineCategoryDAO();
            $category    = new \w2w\Model\Category(null, $name, $description);

//            Check that the category doesn't already exist in the DB, return error message if it does, save the category in the DB otherwise.
            if ($categoryDAO->findOneBy('name', $category->getName())) {
                echo 'failed';
                \w2w\Utils\Utils::message(false, '', 'Catégorie existe déjà.');
            } else {
                echo $categoryDAO->save($category);
                \w2w\Utils\Utils::message(true, 'Catégorie ajoutée', 'Categorie existe déjà');
            }
            
        } else {
            \w2w\Utils\Utils::message(false, '', 'Champ invalide');
        }
    }