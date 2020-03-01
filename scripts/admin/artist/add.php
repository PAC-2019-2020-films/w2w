<?php

checkAdmin();

$firstName = param("firstName");
$lastName = param("lastName");

echo template("admin/form.artist.php", [
    "action" => "/admin/artist/save.php",
    "submitLabel" => "Ajouter",
    "firstName" => $firstName,
    "lastName" => $lastName,
]);
