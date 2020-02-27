<?php
//    Ensure that a user is logged in
    global $user;
    checkUser();

//    Get the current password and new password from the submitted form
    $password           = param('password');
    $newPassword        = param('newPassword');
    $newPasswordConfirm = param('newPasswordConfirm');

//    Validate input
    $rawInput = [
        'newPassword'        => ['password', $newPassword, false],
        'newPasswordConfirm' => ['password', $newPasswordConfirm, false]
    ];
    
    if (\w2w\Utils\Utils::inputValidation($rawInput)) {
//        Check that new passwords match each other
        if ($newPasswordConfirm === $newPassword) {
//            Check that current password matches with the one stored in the db
            if (password_verify($password, $user->getPasswordHash())) {
            
//                Update and save the user password
                $userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();
                $user->setPasswordHash(password_hash($newPassword, PASSWORD_DEFAULT));
                $userDAO->save($user);
                
//                Set flashbag message and redirect
                \w2w\Utils\Utils::message(true, 'password mis à jour', 'Passwords incorrect.');
                header("Location: /account/profile.php");
                exit();
                
            } else {
                \w2w\Utils\Utils::message(false, '', 'Passwords incorrect.');
                header("Location: /account/profile.php");
                exit();
            }
            
        } else {
            \w2w\Utils\Utils::message(false, '', 'Passwords do not match.');
            header("Location: /account/profile.php");
            exit();
        }
        
    } else {
        \w2w\Utils\Utils::message(false, '', 'Champ invalide.');
        header("Location: /account/profile.php");
        exit();
    }