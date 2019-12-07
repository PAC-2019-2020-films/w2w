<?php
/*******************************************************************************
 * 'bootstrap.php' - bootstrapping file
 * 
 * FR_APPPATH : base application directory
 * FR_SRCPATH : application-specific source code
 * FR_VARPATH : installation-specific ressources (config, cache, logs...)
 * FR_DOCROOT : web public directory (index.php, etc...)
 * 
 * default structure (set constants in 'index.php' to modify behaviour) :
 * ../                              (= FR_APPPATH)
 * ../appsrc/                           (= FR_SRCPATH)
 * ../appsrc/bootstrap.php                  (= this file)
 * ../appsrc/classes/
 * ../appsrc/classes/controllers/
 * ../appsrc/views/
 * ../appvar/                           (= FR_VARPATH)
 * ../appvar/cache/
 * ../appvar/logs/
 * ../www/                              (= FR_DOCROOT)
 ******************************************************************************/

/*******************************************************************************
 * against multiple inclusions of this file :
 ******************************************************************************/

if (defined("FR_BOOTSTRAP_INCLUDED")) {
    trigger_error("bootstrap file multiple inclusion", E_USER_NOTICE);
    return;
} else {
    define("FR_BOOTSTRAP_INCLUDED", true);
}

/*******************************************************************************
 * defining key constants for application (if not defined yet)
 * 
 * (no trailing slash for directory paths !)
 ******************************************************************************/

defined("FR_START_TIME") or define("FR_START_TIME", microtime(true));
defined("FR_START_MEM") or define("FR_START_MEM", memory_get_usage());
define("FR_ENV_PRODUCTION", "production");
define("FR_ENV_STAGING", 	"staging");
define("FR_ENV_TEST", 		"test");
define("FR_ENV_DEVELOPMENT","development");
defined("FR_ENV") or define("FR_ENV", isset($_SERVER["FR_ENV"]) ? $_SERVER["FR_ENV"] : FR_ENV_PRODUCTION);
defined("FR_DEBUG") or define("FR_DEBUG", in_array(FR_ENV, [FR_ENV_DEVELOPMENT, FR_ENV_TEST]) ? true : false);
defined("DS") or define("DS", DIRECTORY_SEPARATOR);
defined("FR_APPPATH") or define("FR_APPPATH", realpath(__DIR__ . "/.."));
defined("FR_SRCPATH") or define("FR_SRCPATH", FR_APPPATH . "/appsrc");
defined("FR_VARPATH") or define("FR_VARPATH", FR_APPPATH . "/appvar");
defined("FR_DOCROOT") or define("FR_DOCROOT", FR_APPPATH . "/www");
#!!! dangerous to rely upon php_sapi_name() only
defined("FR_CLI") or define("FR_CLI", (php_sapi_name() === "cli" or defined('STDIN')));
defined("FR_AUTORUN") or define("FR_AUTORUN", false);


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
 * bootstrapping :
 ******************************************************************************/

ini_set("default_charset", "utf-8");

include FR_SRCPATH . "/classes/Fr/Autoloader.php";

if (file_exists(FR_APPPATH . "/vendor/autoload.php")) {
    # inclusion du fichier d'autoload de Composer pour les dépendances (Doctrine...)
    include FR_APPPATH . "/vendor/autoload.php";
}

if (class_exists("\\Fr\\Autoloader")) {
    $autoloader = new Fr\Autoloader();
    $autoloader->register();
    if (class_exists("\\Fr\\Application")) {
        # loads application configuration :
        $app =  new \Fr\Application();
        if (FR_AUTORUN) {
            # runs application :
            $app->run();
        }
        return true;
    }
}

# ...failure while trying to bootstrap application :
if (FR_CLI) {
    trigger_error("cli bootstrap failure", E_USER_NOTICE);
    echo "cli bootstrap failure";
} else {
    //header('HTTP/1.1 500 Internal Server Error');
    header('HTTP/1.0 503 Service Unavailable');
    echo "web bootstrap failure";
}
return false;
