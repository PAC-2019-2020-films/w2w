<?php
global $user;

if ($user == null) {
    echo "Déjà déconnecté.";
    return;
}
?>

<form method="post" action="logout_action.php">
    <input type="submit" value="logout"/>
</form>
