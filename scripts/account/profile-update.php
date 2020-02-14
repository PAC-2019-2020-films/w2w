<?php
checkUser();

global $user;

$username = param('username');
$email = param('email');
$firstName = param('firstName');
$lastName = param('lastName');
$updatedAt = new DateTime('now', new DateTimeZone('Europe/Brussels'));


$rawInput = [
    'username' => ['alphanum', $username, null],
    'email' => ['email', $email, null],
    'firstName' => ['alpha', $firstName, null],
    'lastName' => ['alpha', $lastName, null],
];

if (\w2w\Utils\Utils::inputValidation($rawInput)) {
    $userId = $user->getId();

    $userDAO = new \w2w\DAO\Doctrine\DoctrineUserDAO();

    if ($user = $userDAO->findOneBy('id', $userId)) {

        if ($email != $user->getEmail()) {
//            TODO send validation mail
        }

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setUpdatedAt($updatedAt);

        $result = $userDAO->update($user);
        w2w\Utils\Utils::message($result, 'Profil mis à jour', 'Erreur lors de la mise à jour du profil.');

        header("Location: /account/profile.php");
        exit();
    }

} else {
    w2w\Utils\Utils::message(false, '', 'Champ invalide.');
    header("Location: /account/profile.php");
    exit();
}