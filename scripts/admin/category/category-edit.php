<?php

checkAdmin();

$catId = param('catId');
$catName = param('categoryName');
$catDesc = param('categoryDescription');

$rawInput = [
    'id' => ['num', $catId, false],
    'name' => ['alphanumsoft', $catName, false],
    'desc' => ['alphanumsoft', $catDesc, false],
];


if (\w2w\Utils\Utils::inputValidation($rawInput)) {
    $categoryDAO = new \w2w\DAO\Doctrine\DoctrineCategoryDAO();
    if ($category = $categoryDAO->findOneBy('id', $catId)) {
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