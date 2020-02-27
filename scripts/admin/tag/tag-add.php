<?php
//    Ensure that an admin is logged in
if (checkAdmin()) {

//    Get the tag data from the form
    $name = param('nameTag');
    $description = param('description');

//    Input validation
    $rawInput = [
        'name' => ['alpha', $name, false],
        'description' => ['alphanum', $description, false]
    ];

    if (\w2w\Utils\Utils::inputValidation($rawInput)) {
//        Check that the tag doesn't already exist in the DB
        $tagDAO = new \w2w\DAO\Doctrine\DoctrineTagDAO();

        if ($tagDAO->findOneBy('name', $name)) {
            echo 'failed';
            \w2w\Utils\Utils::message(false, '', 'Tag existe déjà.');
        } else {
//              Create a new tag object from the form data and save it to the DB
            $tag = new \w2w\Model\Tag(null, $name, $description);
            echo $tagDAO->save($tag);
            \w2w\Utils\Utils::message(true, 'Tag ajoutée', 'Tag existe déjà');
        }

    } else {
        \w2w\Utils\Utils::message(false, '', 'Champ invalide');
    }
}