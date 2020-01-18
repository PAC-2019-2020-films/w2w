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
} else  {
	ini_set('log_errors', 0);
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
	error_reporting(0);
}



/*******************************************************************************
 * autoload des classes propres à w2w
 ******************************************************************************/

spl_autoload_register(function($className) {
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
function renderScript($scriptUri, $data = array()) {
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
        return $content;
    } else {
        return "script not found (name={$scriptUri}, path={$scriptPath})";
    }
}

/**
 * Exécute un template et renvoie le résultat (flux de sortie) de son exécution.
 * Pour pouvoir réutiliser des templates dans différents scripts.
 */
function template($name, $data = array()) {
    return renderScript("/templates/{$name}", $data);
}

/**
 * fonction d'échappement des caractères spéciaux pour l'affichage des
 * variables dans les scripts.
 */
function escape($string, $flags = false, $encoding = "utf-8", $double_encode = true) {
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
                        array_map('strip_tags', $value);
                        array_map('trim', $value);
                    } else {
                        $value = strip_tags($value);
                        $value = trim($value);
                    }
                }
            }
            return $value;
        }
    }
    return $default;
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
function web_run() {
    # démmarage session PHP :
    session_start();
    # récupération de l'utilisateur si session ouverte
    if (isset($_SESSION["user"])) {
        global $user;
        $userId = $_SESSION["user"];
        $daoFactory = \w2w\DAO\DAOFactory::getDAOFactory();
        $userDAO = $daoFactory->getUserDAO();
        $user = $userDAO->find($userId);
    }
    # récupération de la request uri :
    $requestURI = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : "/";
    if ($requestURI == "/" || ! $requestURI) {
        $requestURI = "/homepage.php";
    }
    # exécution du script correspondant :
    $content = renderScript($requestURI);
    # insertion du résultat dans la mise en page (layout) du site :
    include FR_SCRIPT_PATH . "/templates/layout.php";
}

/*******************************************************************************
 * démarrage de l'application
 ******************************************************************************/

if (FR_CLI) {
    # si on est en ligne de commande, on arrête ici
    return;
}

web_run();
