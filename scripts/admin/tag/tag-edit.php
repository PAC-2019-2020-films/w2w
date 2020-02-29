<?php
//    Ensure that an admin is logged in
if (checkAdmin()) {

//        Get the category data form the submitted form
    $tagId   = param('tagId');
    $tagName = param('tagName');
    $tagDesc = param('tagDescription');

//        Input validation
    $rawInput = [
        'id'   => ['num', $tagId, false],
        'name' => ['alphanumsoft', $tagName, false],
        'desc' => ['alphanumsoft', $tagDesc, false],
    ];

    if (\w2w\Utils\Utils::inputValidation($rawInput)) {
        $tagDAO = new \w2w\DAO\Doctrine\DoctrinetagDAO();
//            Find the matching category object from the DB
        if ($tag = $tagDAO->findOneBy('id', $tagId)) {
//                Update the Category Object
            $tag->setName($tagName);
            $tag->setDescription($tagDesc);
            $result = $tagDAO->update($tag);
            \w2w\Utils\Utils::message($result, 'tag mis à jour.', 'Erreur lors de la mise à jour du tag');
        } else {
            \w2w\Utils\Utils::message(false, '', 'Erreur lors de la mise à jour du tag');
        }

    } else {
        \w2w\Utils\Utils::message(false, '', 'Champ invalide');
    }
}