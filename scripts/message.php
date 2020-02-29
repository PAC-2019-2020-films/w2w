<?php 
use \w2w\DAO\DAOFactory;
use \w2w\Model\Message;
use \w2w\Utils\FlashManager;

$firstName = param("firstName");
$lastName = param("lastName");
$email = param("email");
$content = param("content");


$flashManager = new FlashManager();

$ok = true;

if (! $lastName) {
    $flashManager->error("Veuillez fournir un nom.");
    $ok = false;
}
if (! $email) {
    $flashManager->error("Veuillez fournir un email.");
    $ok = false;
}
if (! $content) {
    $flashManager->error("Veuillez fournir un message.");
    $ok = false;
}

if (! $ok) {
    echo template("form.message.php", [
        "firstName" => $firstName,
        "lastName" => $lastName,
        "email" => $email,
        "content" => $content,
    ]);
    return;
}

$daoFactory = DAOFactory::getDAOFactory();
$messageDAO = $daoFactory->getMessageDAO();

$message = new \w2w\Model\Message(null, $firstName, $lastName, $email, $content, new \DateTime(), false);
$messageDAO->save($message);
if ($message->getId() > 0) {
    $flashManager->success("Message enregistré.");
} else {
    $flashManager->error("Échec lors de 'enregistrement de votre message.");
}


