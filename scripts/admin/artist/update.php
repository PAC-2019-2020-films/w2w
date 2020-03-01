<?php
use \w2w\DAO\DAOFactory;
use \w2w\Model\Artist;
use \w2w\Utils\FlashManager;

checkAdmin();

$id = param("id");
$firstName = param("firstName");
$lastName = param("lastName");

$daoFactory = DAOFactory::getDAOFactory();
$artistDAO = $daoFactory->getArtistDAO();
$artist = $artistDAO->find($id);
$flashManager = new FlashManager();

if (! $artist) {
    redirectWarning("/admin/?active-actions=artist", "Artiste non trouvé.");
}

# vérification que le nom est non vide : 

if (! $lastName) {
    $flashManager->error("Veuillez fournir un nom.");
} else {

    # modification et sauvegarde en bdd :
    
    $artist->setFirstName($firstName);
    $artist->setLastName($lastName);
    $artistDAO->update($artist);
    
    redirectSuccess("/admin/?active-actions=artist", "Artiste modifié.");

}
    
# échec, réaffichage formulaire :

echo template("admin/form.artist.php", [
    "action" => "/admin/artist/update.php",
    "submitLabel" => "Ajouter",
    "id" => $id,
    "firstName" => $firstName,
    "lastName" => $lastName,
]);
