<?php
use \w2w\DAO\DAOFactory;
use \w2w\Model\Artist;

checkAdmin();

$id = param("id");

$daoFactory = DAOFactory::getDAOFactory();
$artistDAO = $daoFactory->getArtistDAO();
$artist = $artistDAO->find($id);

if (! $artist) {
    redirectWarning("/admin/?active-actions=artist", "Artiste non trouvé.");
}

echo template("admin/form.artist.php", [
    "action" => "/admin/artist/update.php",
    "submitLabel" => "Modifier",
    "id" => $id,
    "firstName" => $artist->getFirstName(),
    "lastName" => $artist->getLastName(),
]);
