<?php
global $user;

if ($user != null) {
    echo "Déjà connecté.";
    return;
}

$email = param("email");
$password = param("password");

if ($email && $password) {
    $daoFactory = \w2w\DAO\DAOFactory::getDAOFactory();
    $userDAO = $daoFactory->getUserDAO();
    if ($user = $userDAO->findByEmail($email)) {
        if (password_verify($password, $user->getPasswordHash())) {
            $_SESSION["user"] = $user->getId();
            echo "ok";
            return;
        }
    }
}

echo "Erreur.";
