<?php
    checkAdmin();
    
    $name        = param("nameCat");
    $description = param("description");
    
    $rawInput = [
        'name' => ['alpha', $name, false],
        'desc' => ['alpha', $description, false]
    ];
    
    if (\w2w\Utils\Utils::inputValidation($rawInput)) {
        
        $categoryDAO = new \w2w\DAO\Doctrine\DoctrineCategoryDAO();
        $category    = new \w2w\Model\Category(null, $name, $description);
        
        if ($categoryDAO->findOneBy('id', $category->getName())) {
            \w2w\Utils\Utils::message(false, '', 'Categorie existe déjà');
            echo "fail";
        } else {
            echo $categoryDAO->save($category);
        }
        
        
    }