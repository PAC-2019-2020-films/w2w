<?php

// Potential issue : an admin can only ban user, root can ban admin,... -> role value is weighted based on DB ids
// this can be problematic if more roles are added in the future, a simple fix would be to add numeric weight/value to roles in the DB
// This is post project tho...


checkAdmin();

$userId = param('userId');
$userIsBanned = boolval(param('userIsBanned'));

$userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();
$user = $userDAO->findOneBy('id', $userId);


if ($user) {
    if ($_SESSION['role'] > $user->getRole()->getId()) {
        $user->setBanned(!$userIsBanned);
        $result = $userDAO->update($user);
        \w2w\Utils\Utils::message($userIsBanned, "Utilisateur restauré.", "Utilisateur banni.");
    }
}