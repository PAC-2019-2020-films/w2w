<?php

// Potential issue : an admin can only ban user, root can ban admin,... -> role value is weighted based on DB ids
// this can be problematic if more roles are added in the future, a simple fix would be to add numeric weight/value to roles in the DB
// This is post project tho...

//    Ensure that an admin is logged in
    if (checkAdmin()) {

//        Get the target user id and whether or not he's already banned
        $userId       = param('userId');
        $userIsBanned = boolval(param('userIsBanned'));

//        TODO : input validation

//        Find the matching user object from the DB
        $userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();
        $user    = $userDAO->findOneBy('id', $userId);

//        Ensure that a match has been found
        if ($user) {
//            Check that the currently logged user role is superior to the targeted user
            if ($_SESSION['role'] > $user->getRole()->getId()) {
//                Ban or unban the target user  and save the user object in the DB
                $user->setBanned(!$userIsBanned);
                $result = $userDAO->update($user);
                \w2w\Utils\Utils::message($userIsBanned, "Utilisateur restauré.", "Utilisateur banni.");
            }
        }
    }