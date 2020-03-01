<?php

use \w2w\DAO\DAOFactory;

checkAdmin();

$id = param("id");
$daoFactory = DAOFactory::getDAOFactory();
$messageDAO = $daoFactory->getMessageDAO();
$message = $messageDAO->find($id);

if (! $message) {
    redirectWarning("/admin/?active-actions=message", "Message non trouvé (#$id)");
}

$message->setTreated(true);
$messageDAO->update($message);

redirectSuccess("/admin/?active-actions=message", "Modifié.");
