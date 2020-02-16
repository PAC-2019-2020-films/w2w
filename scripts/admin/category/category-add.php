<?php
checkAdmin();

$name = param("nameCat");
$description = param("description");

$rawInput = [
    'name' => ['alpha', $name, false],
    'desc' => ['alpha', $description, false]
];

if (\w2w\Utils\Utils::inputValidation($rawInput)) {

    $categoryDAO = new \w2w\DAO\Doctrine\DoctrineCategoryDAO();
    $category = new \w2w\Model\Category(null, $name, $description);

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