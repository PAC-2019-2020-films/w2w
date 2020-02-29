<?php
//    Ensure that an admin is logged in
if (checkAdmin()) {
    $id = param("id");
    $confirm = param("confirm");
    $context = param('context');

//    Input validation
    $rawInput = [
        'id' => ['num', $id, false],
        'confirm' => ['alpha', $confirm, false],
        'context' => ['alpha', $context, false]
    ];

    if (\w2w\Utils\Utils::inputValidation($rawInput)) {
//        Find the target tag in the DB
        $tagDAO = new \w2w\DAO\Doctrine\DoctrineTagDAO();
        $tag = $tagDAO->findOneBy('id', $id);

//        If no matching tag could be found return error otherwise delete the tag from DB
        if (!$tag) {
            \w2w\Utils\Utils::message(false, '', 'Tag non trouvé');
            if ($context == 'ajax') {
                echo "tag not found";
            } else {
                header('Location: /admin/category/category-list.php');
                exit();
            }
        } else {
            $tagDAO->delete($tag);
        }

    } else {
        \w2w\Utils\Utils::message(false, '', 'Champ invalide');
    }


}