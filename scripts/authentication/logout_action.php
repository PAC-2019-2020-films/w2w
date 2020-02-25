<?php
global $user;

if ($user == null) {
    echo "Déjà déconnecté.";
    return;
}

# mise à null de notre objet User global
$user = null;

/*
 * https://www.php.net/manual/fr/function.session-destroy.php :
 */

// Détruit toutes les variables de session
$_SESSION = array();

// Si vous voulez détruire complètement la session, effacez également
// le cookie de session.
// Note : cela détruira la session et pas seulement les données de session !
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalement, on détruit la session.
session_unset();
session_destroy();    
//
//echo "ok";
header('location:../homepage.php');
exit();
