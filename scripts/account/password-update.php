<?php
checkUser();

global $user;

$password = param('password');
$newPassword = param('newPassword');
$newPasswordConfirm = param('newPasswordConfirm');

$rawInput = [
    'newPassword' => ['password', $newPassword, false],
    'newPasswordConfirm' => ['password', $newPasswordConfirm, false]
];

if (\w2w\Utils\Utils::inputValidation($rawInput)) {
    if ($newPasswordConfirm === $newPassword) {
        if (password_verify($password, $user->getPasswordHash())) {
            $userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();
            $user->setPasswordHash(password_hash($newPassword, PASSWORD_DEFAULT));
            $userDAO->save($user);

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