<?php
use \w2w\DAO\DAOFactory;
use \w2w\Model\Artist;
use \w2w\Utils\FlashManager;

checkAdmin();

$firstName = param("firstName");
$lastName = param("lastName");

$daoFactory = DAOFactory::getDAOFactory();
$artistDAO = $daoFactory->getArtistDAO();

$flashManager = new FlashManager();

# vérification que le nom est non vide : 

if (! $lastName) {
    $flashManager->error("Veuillez fournir un nom.");
} else {

    # instanciation et sauvegarde en bdd :
    
    $artist = new Artist(null, $firstName, $lastName);
    $artistDAO->save($artist);
    
    # succès, renvoie à liste artistes :
    
    if ($artist->getId() > 0) {
        redirectSuccess("/admin/?active-actions=artist", "Artiste ajouté.");
    }

}

    
# échec, réaffichage formulaire :

echo template("admin/form.artist.php", [
    "action" => "/admin/artist/save.php",
    "submitLabel" => "Ajouter",
    "firstName" => $firstName,
    "lastName" => $lastName,
]);
