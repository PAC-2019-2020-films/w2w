<?php
//    Ensure that an admin is logged in
    if (checkAdmin()) {
    
//        Get the category data form the submitted form
        $catId   = param('catId');
        $catName = param('categoryName');
        $catDesc = param('categoryDescription');
        
//        Input validation
        $rawInput = [
            'id'   => ['num', $catId, false],
            'name' => ['alphanumsoft', $catName, false],
            'desc' => ['alphanumsoft', $catDesc, false],
        ];
        
        if (\w2w\Utils\Utils::inputValidation($rawInput)) {
            $categoryDAO = new \w2w\DAO\Doctrine\DoctrineCategoryDAO();
//            Find the matching category object from the DB
            if ($category = $categoryDAO->findOneBy('id', $catId)) {
//                Update the Category Object
                $category->setName($catName);
                $category->setDescription($catDesc);
                $result = $categoryDAO->update($category);
                \w2w\Utils\Utils::message($result, 'Catégorie mise à jour.', 'Erreur lors de la mise à jour de la catégorie');
            } else {
                \w2w\Utils\Utils::message(false, '', 'Erreur lors de la mise à jour de la catégorie');
            }
            
        } else {
            \w2w\Utils\Utils::message(false, '', 'Champ invalide');
        }
    }