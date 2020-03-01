<?php
use \w2w\DAO\DAOFactory;
use \w2w\Model\Artist;

checkAdmin();

$id = param("id");
$confirm = param("confirm");

$daoFactory = DAOFactory::getDAOFactory();
$artistDAO = $daoFactory->getArtistDAO();
$artist = $artistDAO->find($id);

if (! $artist) {
    redirectWarning("/admin/?active-actions=artist", "Artiste non trouvé.");
}

# confirmation reçue, on efface et on redirige :
if ($confirm == "confirm") {
    $artistDAO->delete($artist);
    redirectWarning("/admin/?active-actions=artist", "Artiste effacé.");
}

# on affiche le formulaire de confirmation :

echo template("admin/form.delete-confirm.php", [
    "id" => $id,
    "message" => sprintf("Supprimer l'artiste %s ?", $artist->getFirstName() . " " . $artist->getLastName()),
    "action" => "/admin/artist/delete.php",
]);
