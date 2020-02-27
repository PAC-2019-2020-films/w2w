<?php

/*******************************************************************************
 * constantes paramétrant l'application :
 ******************************************************************************/

# si on affiche les messages d'erreur et les informations de debug :
define("FR_DEBUG", true);
# chemin complet vers la base du répertoire de l'application :
define("FR_APPPATH", realpath(__DIR__));
# chemin complet vers les scripts :
define("FR_SCRIPT_PATH", FR_APPPATH . "/scripts");
# chemin complet vers les classes :
define("FR_CLASS_PATH", FR_APPPATH . "/classes");
# assets paths
define('IMG_PATH_MOVIES', FR_APPPATH . '/uploads/');
# si on est en ligne de commande et pas en mode web :
define("FR_CLI", (php_sapi_name() === "cli" or defined('STDIN')));
# identifiants de bdd :
define("DB_HOSTNAME", "localhost");
define("DB_USERNAME", "w2w");
define("DB_PASSWORD", "w2w");
define("DB_DATABASE", "w2w");
define("DB_SCHEME", "mysql");
define("DB_DRIVER", "pdo_mysql");


//ini_set("default_charset", "utf-8");

/*******************************************************************************
 * error reporting :
 ******************************************************************************/

if (FR_DEBUG) {
    ini_set('log_errors', 0); // -> STDERR
    ini_set('display_errors', 1); // -> STDOUT
    ini_set('display_startup_errors', 1);
    error_reporting(-1);
} else {
    ini_set('log_errors', 0);
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}


/*******************************************************************************
 * autoload des classes propres à w2w
 ******************************************************************************/

spl_autoload_register(function ($className) {
    $classPathBase = FR_CLASS_PATH;
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    $classPath = ($classPathBase ? $classPathBase . DIRECTORY_SEPARATOR : "") . $className . '.php';
    $loaded = false;
    if (is_file($classPath)) {
        include $classPath;
        $loaded = true;
    }
    return $loaded;
});


/*******************************************************************************
 * autoload des classes des dépendances Composer
 ******************************************************************************/

if (file_exists(FR_APPPATH . "/vendor/autoload.php")) {
    # inclusion du fichier d'autoload de Composer pour les dépendances (Doctrine...)
    include FR_APPPATH . "/vendor/autoload.php";
}


/*******************************************************************************
 * fonction utilitaires dans l'ensemble de l'application
 ******************************************************************************/

/**
 * Exécute un script PHP et utilise l'output buffering
 * (écriture du flux de sortie dans un tampon) pour récupérer dans
 * une variable ce que l'excéution du script aurait affiché dans le navigateur
 * si l'output buffering n'était pas activé.
 *
 * Le but est de pouvoir ensuite insérer le contenu généré par le script
 * dans le layout de mise en page commune à tout le site.
 *
 * https://www.php.net/manual/fr/ref.outcontrol.php
 */
function renderScript($scriptUri, $data = array())
{
    $scriptPath = FR_SCRIPT_PATH . $scriptUri;
    if (is_file($scriptPath)) {
        foreach ($data as $key => $value) {
            $$key = $value;
        }
        # début de l'écriture du flux de sortie dans un tampon :
        ob_start();
        include $scriptPath;
        # récupération du contenu du tampon :
        $content = ob_get_contents();
        # fin de l'écriture du flux de sortie dans un tampon :
        ob_end_clean();

        # Pour certains scripts non triviaux, 
        # on les associe à un autre script dit "de vue",
        # afin de séparer traitement et présentation des données,
        # et de limiter les risques de conflits de merge.
        #
        # On teste si un tel script existe pour celui-ci ; 
        # si oui on l'exécute également de la même manière :
        $viewScriptPath = str_replace(".php", ".view.php", $scriptPath);
        if (is_file($viewScriptPath)) {
            ob_start();
            include $viewScriptPath;
            $content .= ob_get_clean();
        }
        return $content;
    } else {
        return "script not found (name={$scriptUri}, path={$scriptPath})";
    }

}

/**
 * Exécute un template et renvoie le résultat (flux de sortie) de son exécution.
 * Pour pouvoir réutiliser des templates dans différents scripts.
 */
function template($name, $data = array())
{
    return renderScript("/templates/{$name}", $data);
}

/**
 * fonction d'échappement des caractères spéciaux pour l'affichage des
 * variables dans les scripts.
 */
function escape($string, $flags = false, $encoding = "utf-8", $double_encode = true)
{
    if ($flags === false) {
        $flags = ENT_COMPAT | ENT_HTML401;
    }
    return htmlentities($string, $flags, $encoding, $double_encode);
}

/**
 * récupération d'un paramètre HTTP (GET, POST ou COOKIE)
 */
function param($name, $default = null, $filter = true)
{
    foreach (array($_POST, $_GET, $_COOKIE) as $superglobal) {
        if (isset($superglobal[$name])) {
            $value = $superglobal[$name];
            if ($filter) {
                if ($value !== null && $value !== 0) {
                    if (is_array($value)) {
                        // "Warning: array_map(): Expected parameter 3 to be an array, string given"
                        // see https://www.php.net/manual/fr/function.array-map.php
                        // array_map('strip_tags', $value, '<strong></strong> <li></li> <em></em> <ul></ul> <ol></ol> <p></p> <a></a>');
                        array_map('strip_tags', $value);
                        array_map('trim', $value);
                    } else {
                        $value = strip_tags($value, '<strong></strong> <li></li> <em></em> <ul></ul> <ol></ol> <p></p> <a></a>');
                        $value = trim($value);
                    }
                }
            }
            return $value;
        }
    }
    return $default;
}


function error401($msg = "401 Unauthorized")
{
    header("HTTP/1.1 401 Unauthorized");
    echo $msg;
    exit();
}

/**
 * Afficvhage d'un message de redirection
 *
 * Si $delay vaut 0 : simple redirection instantanée via en-tête http
 *      (le message affiché n'aura pas le temps d'être lu...)
 * Si $delay vaut null : le script "redirect.php" affiche juste le message et un lien vers l'url
 *      (pas de redirection automatique vers l'url)
 */
function redirect_deprecated($url, $msg = null, $delay = null)
{
    if ($delay === 0) {
        header("Location: {$url}");
        echo escape($msg);
        exit();
    } else {
        echo renderScript("/templates/message.php", [
            "url" => $url,
            "msg" => $msg,
            "delay" => $delay,
        ]);
        exit();
    }
}

function redirect($result, $ok, $not, $url)
{
    \w2w\Utils\Utils::message($result, $ok, $not);
    header('Location: ' . $url);
    exit();
}

function redirectSuccess($url, $msg)
{
    redirect(true, $msg, null, $url);
}

function redirectWarning($url, $msg)
{
    redirect(false, null, $msg, $url);
}


function checkBanned(){
    global $user;

    if ($user && $user instanceof \w2w\Model\User && $user->isBanned()){
        require 'scripts/authentication/logout_action.php';
        \w2w\Utils\Utils::message(false, '', 'Votre compte a été suspendu.');
        exit();
    }
}


/**
 * vérifie que l'utilisateur est connecté
 */
function checkUser()
{
    global $user;
    if ($user && $user instanceof \w2w\Model\User && !$user->isBanned()) {
        return true;
    }
    error401();
}

/**
 * vérifie que l'utilisateur est connecté et a les droits d'admin
 */
function checkAdmin()
{
    global $user;
    if ($user && $user instanceof \w2w\Model\User && $user->isAdmin() && !$user->isBanned()) {
        return true;
    }
    error401();
}

/**
 * vérifie que l'utilisateur est connecté et a les droits de root
 */
function checkRoot()
{
    global $user;
    if ($user && $user instanceof \w2w\Model\User && $user->isRoot() && !$user->isBanned()) {
        return true;
    }
    error401();
}


/**
 * Traitement d'une requête web.
 *
 * On recupère l'URI de la requête (ex:'/movie/add.php) et on la redirige
 * vers un script correspondant via un appel à la méthode renderScript()
 * Le résultat renvoyé par l'exécution du script est inséré dans
 * la mise en page (layout) commune à tout le site
 * via un simple include du fichier de layout.
 */
function web_run()
{
    # démmarage session PHP :
    session_start();
    # récupération de l'utilisateur si session ouverte
    if (isset($_SESSION["user"])) {
        global $user;
        # déclaration d'une seconde variable globale pour accéder au même objet User
        # même à l'intérieur de boucles de type "foreach ($users as $user)..."
        # (les variables globales, c'est facile mais c'est dangereux : "effets de bord") :
        global $sessionUser;
        $userId = $_SESSION["user"];
        $daoFactory = \w2w\DAO\DAOFactory::getDAOFactory();
        $userDAO = $daoFactory->getUserDAO();
        $sessionUser = $user = $userDAO->find($userId);
    }
    # récupération de la request uri :
    $requestURI = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : "/";

    # ! il faut retirer les éventuels paramètres GET après '?' :
    if (($pos = strpos($requestURI, "?")) !== false) {
        $requestURI = substr($requestURI, 0, $pos);
    }

    if ($requestURI == "/" || !$requestURI) {
        # page d'accueil du site
        $requestURI = "/homepage.php";
    } elseif (strlen($requestURI) > 0 && $requestURI[strlen($requestURI) - 1] == "/") {
        # page d'index des sous-répertoires, pour les cas de type :
        # /admin/ => /admin/index.php
        # /account/ => /account/index.php
        $requestURI .= "index.php";
    }
    # exécution du script correspondant :
    $content = renderScript($requestURI);

    # insertion du résultat dans la mise en page (layout) du site :
    # (dans le cas d'une requête ajax on renvoie le contenu sans l'insérer dans le layout)
    if (param('context') != 'ajax') {
        include FR_SCRIPT_PATH . "/templates/layout.php";
    } else {
        if (isset($content))
            echo $content;

    }
}


/*******************************************************************************
 * démarrage de l'application
 ******************************************************************************/

if (FR_CLI) {
# si on est en ligne de commande, on arrête ici
    return;
}

web_run();
