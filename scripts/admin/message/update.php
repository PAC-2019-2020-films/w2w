<?php

use \w2w\DAO\DAOFactory;

checkAdmin();

$id = param("id");
$daoFactory = DAOFactory::getDAOFactory();
$messageDAO = $daoFactory->getMessageDAO();
$message = $messageDAO->find($id);

if (! $message) {
    redirectWarning("/admin/", "Message non trouv (#$id)");
}

$message->setTreated(true);
$messageDAO->update($message);

redirectSuccess("/admin/", "Modifié.");
