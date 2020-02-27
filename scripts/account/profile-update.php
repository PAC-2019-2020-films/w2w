<?php
//    Ensure that a user is logged in
    global $user;
    checkUser();
    
//    Get user profile data from submitted form
    $username  = param('username');
    $email     = param('email');
    $firstName = param('firstName');
    $lastName  = param('lastName');
//    Set updatedAt time at NOW
    $updatedAt = new DateTime('now', new DateTimeZone('Europe/Brussels'));
    
//    Validate input
    $rawInput = [
        'username'  => ['alphanum', $username, null],
        'email'     => ['email', $email, null],
        'firstName' => ['alpha', $firstName, null],
        'lastName'  => ['alpha', $lastName, null],
    ];
    
    if (\w2w\Utils\Utils::inputValidation($rawInput)) {
    
//        Get the matching user object form the DB
        $userId = $user->getId();
        $userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();
        if ($user = $userDAO->findOneBy('id', $userId)) {
        
//            If the user changed his email adress : set a new confirmation email and update the emailVerified to false.
            if ($email != $user->getEmail()) {
//            TODO send validation mail
            }
            
//            Update the user object properties with the ones provided in the form
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setUpdatedAt($updatedAt);
            
//            Persist the user object in the DB
            $result = $userDAO->update($user);
            
//            Set flashbag message
            w2w\Utils\Utils::message($result, 'Profil mis à jour', 'Erreur lors de la mise à jour du profil.');
            
//            Redirect to profile page
            header("Location: /account/profile.php");
            exit();
        }
        
    } else {
        w2w\Utils\Utils::message(false, '', 'Champ invalide.');
        header("Location: /account/profile.php");
        exit();
    }